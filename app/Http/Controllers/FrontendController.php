<?php

namespace App\Http\Controllers;

use App\Models\AccountingTemplate;
use App\Models\AdminService;
use App\Models\AgricultureGuide;
use App\Models\PosyanduSchedule;
use App\Models\PublicFacility;
use App\Models\TaxGuide;
use App\Models\VillagePotential;
use App\Models\VillageProfile;
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

    public function taxes(): View
    {
        return view('pages.taxes', [
            'guides' => TaxGuide::query()->orderBy('kategori_umkm')->get(),
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
