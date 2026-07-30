<?php

namespace App\Http\Controllers;

use App\Mail\NewServiceRequestMail;
use App\Models\AccountingTemplate;
use App\Models\AdminService;
use App\Models\AgricultureGuide;
use App\Models\Faq;
use App\Models\PosyanduSchedule;
use App\Models\PublicFacility;
use App\Models\ServiceRequest;
use App\Models\TaxGuide;
use App\Models\TaxSchedule;
use App\Models\Umkm;
use App\Models\VillagePotential;
use App\Models\VillageProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function home(): View
    {
        return view('welcome');
    }

    public function profile(): View
    {
        return view('pages.profile', [
            'profile' => VillageProfile::query()->latest()->first(),
        ]);
    }

    public function services(): View
    {
        return view('pages.services', [
            'services' => AdminService::query()->latest()->get(),
        ]);
    }

    public function storeServiceRequest(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'admin_service_id' => ['required', 'exists:admin_services,id'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16'],
            'alamat' => ['required', 'string'],
            'no_whatsapp' => ['required', 'string', 'max:20'],
            'file_lampiran' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('file_lampiran')) {
            $data['file_lampiran'] = $request->file('file_lampiran')->store('service-requests', 'public');
        }

        $serviceRequest = ServiceRequest::create($data);

        try {
            Mail::to(config('mail.from.address'))->send(new NewServiceRequestMail($serviceRequest->load('adminService')));
        } catch (\Throwable $exception) {
            Log::warning('Notifikasi email pengajuan layanan gagal.', ['exception' => $exception->getMessage()]);
        }

        return back()->with('success', 'Pengajuan berhasil dikirim. Pemerintah desa akan menghubungi Anda.');
    }

    public function facilities(): View
    {
        return view('pages.facilities', [
            'facilities' => PublicFacility::query()->orderBy('nama_fasilitas')->get(),
        ]);
    }

    public function agriculture(): View
    {
        return view('pages.agriculture', [
            'guides' => AgricultureGuide::query()->orderBy('nama_alat')->get(),
        ]);
    }

    public function accounting(): View
    {
        return view('pages.accounting', [
            'templates' => AccountingTemplate::query()->latest()->get(),
        ]);
    }

    public function umkm(): View
    {
        return view('pages.umkm', [
            'umkms' => Umkm::query()->orderBy('nama_umkm')->get(),
            'faqs' => Faq::query()->where('kategori', 'umkm')->orderBy('urutan')->get(),
            'categories' => Umkm::query()->distinct()->orderBy('kategori')->pluck('kategori'),
            'dusuns' => Umkm::query()->distinct()->orderBy('dusun')->pluck('dusun'),
        ]);
    }

    public function taxes(): View
    {
        $month = Carbon::now()->startOfMonth();
        $deadline = $month->copy()->day(15);
        $deadlineNote = 'Batas Pelaporan Pajak UMKM';
        if ($deadline->isSunday()) {
            $deadline->subDay();
            $deadlineNote .= ' (dimajukan karena tanggal 15 jatuh pada hari Minggu)';
        }

        return view('pages.taxes', [
            'guides' => TaxGuide::query()->orderBy('kategori_umkm')->get(),
            'taxSchedules' => TaxSchedule::query()->orderBy('tanggal')->get(),
            'faqs' => Faq::query()->where('kategori', 'pajak')->orderBy('urutan')->get(),
            'calendarMonth' => $month, 'taxDeadline' => $deadline, 'taxDeadlineNote' => $deadlineNote,
        ]);
    }

    public function potentials(): View
    {
        return view('pages.potentials', [
            'potentials' => VillagePotential::query()->latest()->get(),
        ]);
    }

    public function posyandu(): View
    {
        return view('pages.posyandu', [
            'schedules' => PosyanduSchedule::query()
                ->orderBy('tanggal_pelaksanaan')
                ->orderBy('jam_mulai')
                ->get(),
        ]);
    }
}
