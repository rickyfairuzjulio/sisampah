<?php

namespace App\Mail;

use App\Models\BankSampah;
use App\Models\BankSampahDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BankSampahRevisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bankSampah;
    public $document;

    public function __construct(BankSampah $bankSampah, BankSampahDocument $document)
    {
        $this->bankSampah = $bankSampah;
        $this->document = $document;
    }

    public function build()
    {
        return $this->subject("[SiSampah] Revisi Dokumen Pendaftaran '{$this->bankSampah->nama}'")
                    ->markdown('emails.bank-sampah-revision');
    }
}
