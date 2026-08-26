import React, { useState } from 'react';
import { Star, X } from 'lucide-react';

export default function RatingModal({ isOpen, transactionId, onClose, onSubmitSuccess }) {
    const [rating, setRating] = useState(0);
    const [hoverRating, setHoverRating] = useState(0);
    const [ulasan, setUlasan] = useState('');
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [errorMsg, setErrorMsg] = useState('');

    if (!isOpen) return null;

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (rating === 0) {
            setErrorMsg('Silakan pilih jumlah bintang rating (1-5)');
            return;
        }

        setIsSubmitting(true);
        setErrorMsg('');

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/nasabah/transaksi/${transactionId}/rating`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    rating,
                    ulasan,
                }),
            });

            if (res.ok) {
                if (onSubmitSuccess) onSubmitSuccess(transactionId, rating, ulasan);
                onClose();
                window.location.reload();
            } else {
                const data = await res.json();
                setErrorMsg(data.message || 'Gagal mengirimkan ulasan');
            }
        } catch (err) {
            console.error(err);
            setErrorMsg('Terjadi kesalahan jaringan');
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
            
            {/* Backdrop */}
            <div
                className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                onClick={onClose}
            />

            {/* Dialog Card */}
            <div className="relative bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 z-10 animate-slide-in space-y-6">
                
                {/* Close Button */}
                <button
                    onClick={onClose}
                    className="absolute top-5 right-5 p-1.5 rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors"
                >
                    <X className="w-5 h-5" />
                </button>

                {/* Title */}
                <div className="text-center space-y-1">
                    <h3 className="text-lg sm:text-xl font-bold text-slate-900">
                        Penilaian Layanan Setoran
                    </h3>
                    <p className="text-xs text-slate-500">
                        Bagaimana kualitas pelayanan penjemputan dan penimbangan oleh petugas?
                    </p>
                </div>

                {/* 5 Star Buttons */}
                <form onSubmit={handleSubmit} className="space-y-5">
                    
                    <div className="flex justify-center items-center gap-2 py-2">
                        {[1, 2, 3, 4, 5].map((star) => {
                            const isFilled = (hoverRating || rating) >= star;
                            return (
                                <button
                                    key={star}
                                    type="button"
                                    onClick={() => setRating(star)}
                                    onMouseEnter={() => setHoverRating(star)}
                                    onMouseLeave={() => setHoverRating(0)}
                                    className="p-1 focus:outline-none transition-transform hover:scale-125"
                                >
                                    <Star
                                        className={`w-9 h-9 ${
                                            isFilled
                                                ? 'text-amber-400 fill-amber-400'
                                                : 'text-slate-300'
                                        } transition-colors`}
                                    />
                                </button>
                            );
                        })}
                    </div>

                    {errorMsg && (
                        <p className="text-xs font-semibold text-red-600 text-center bg-red-50 py-1.5 px-3 rounded-lg">
                            {errorMsg}
                        </p>
                    )}

                    {/* Review Textarea */}
                    <div className="space-y-1.5">
                        <label className="text-xs font-bold text-slate-700 block">
                            Catatan atau Saran (Opsional)
                        </label>
                        <textarea
                            rows={3}
                            value={ulasan}
                            onChange={(e) => setUlasan(e.target.value)}
                            placeholder="Tuliskan pengalaman Anda..."
                            className="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs sm:text-sm text-slate-800 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition-all resize-none"
                        />
                    </div>

                    {/* Action Buttons */}
                    <div className="flex items-center justify-end gap-3 pt-2">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            disabled={rating === 0 || isSubmitting}
                            className="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {isSubmitting ? 'Mengirim...' : 'Kirim Penilaian'}
                        </button>
                    </div>

                </form>

            </div>

        </div>
    );
}
