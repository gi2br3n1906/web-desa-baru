<x-mail::message>
# Pengajuan Layanan Baru

**Layanan:** {{ $serviceRequest->adminService->nama_layanan }}  
**Nama:** {{ $serviceRequest->nama_lengkap }}  
**NIK:** {{ $serviceRequest->nik }}  
**WhatsApp:** {{ $serviceRequest->no_whatsapp }}  
**Status:** Pending

@component('mail::button', ['url' => url('/admin/service-requests')])
Buka Panel Admin
</x-mail::button>

Silakan tindak lanjuti pengajuan melalui panel admin.<br>
{{ config('app.name') }}
</x-mail::message>
