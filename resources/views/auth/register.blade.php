<x-guest-layout>
    @php
        $oldData = [
            'name' => old('name', ''),
            'email' => old('email', ''),
            'bank_sampah_id' => old('bank_sampah_id', ''),
        ];

        $registerErrors = [];
        if ($errors->any()) {
            foreach ($errors->messages() as $field => $messages) {
                $registerErrors[$field] = $messages[0];
            }
        }

        $activeBankSampahs = ($bankSampahs ?? \App\Models\BankSampah::active()->get())->map(fn($b) => [
            'id' => $b->id,
            'nama' => $b->nama,
            'kecamatan' => $b->kecamatan ?? 'Terdekat',
        ]);
    @endphp

    <div id="register-app"
         data-csrf="{{ csrf_token() }}"
         data-old="{{ json_encode($oldData) }}"
         data-errors="{{ json_encode($registerErrors) }}"
         data-banksampahs="{{ json_encode($activeBankSampahs) }}">
    </div>
</x-guest-layout>
