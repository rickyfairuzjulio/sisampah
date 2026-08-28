import React, { useState } from 'react';
import { AlertTriangle, Trash2, X, Lock } from 'lucide-react';

export default function DangerZoneSection({
    csrfToken = '',
    errors = {},
}) {
    const [showModal, setShowModal] = useState(false);
    const [password, setPassword] = useState('');
    const [isDeleting, setIsDeleting] = useState(false);

    const deleteError = errors?.userDeletion?.password || errors?.password;

    return (
        <>
            <div className="bg-red-50/40 dark:bg-red-950/20 border-2 border-red-200 dark:border-red-900/60 rounded-3xl p-6 sm:p-8 space-y-4 transition-colors duration-200">
                
                {/* Header */}
                <div className="flex items-center gap-3.5">
                    <div className="w-10 h-10 rounded-2xl bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-300 border border-red-200 dark:border-red-800 flex items-center justify-center font-bold shrink-0 shadow-2xs">
                        <AlertTriangle className="w-5 h-5" />
                    </div>
                    <div>
                        <h2 className="font-extrabold text-base sm:text-lg text-red-700 dark:text-red-400 tracking-tight">
                            Zona Berbahaya
                        </h2>
                        <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>

                {/* Warning Description */}
                <p className="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    Setelah akun Anda dihapus, seluruh riwayat transaksi timbangan, akumulasi poin lingkungan, saldo SiSampay, dan data sertifikat Anda akan dihapus secara total dari sistem.
                </p>

                {/* Trigger Button */}
                <div className="pt-2">
                    <button
                        type="button"
                        onClick={() => setShowModal(true)}
                        className="px-5 py-2.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2 hover:-translate-y-0.5 cursor-pointer"
                    >
                        <Trash2 className="w-4 h-4" />
                        <span>Hapus Akun Saya Secara Permanen</span>
                    </button>
                </div>

            </div>

            {/* Confirmation Modal Dialog */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                    {/* Backdrop */}
                    <div 
                        className="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
                        onClick={() => setShowModal(false)}
                    />

                    {/* Dialog Container */}
                    <div className="relative bg-white dark:bg-[#111827] rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 max-w-md w-full shadow-2xl z-10 animate-slide-in space-y-5">
                        
                        {/* Close button */}
                        <button
                            type="button"
                            onClick={() => setShowModal(false)}
                            className="absolute top-5 right-5 text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors p-1 cursor-pointer"
                        >
                            <X className="w-5 h-5" />
                        </button>

                        <div className="flex items-center gap-3.5">
                            <div className="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-950 text-red-600 dark:text-red-400 flex items-center justify-center font-bold shrink-0">
                                <AlertTriangle className="w-6 h-6" />
                            </div>
                            <div>
                                <h3 className="font-extrabold text-base sm:text-lg text-slate-900 dark:text-white">
                                    Konfirmasi Hapus Akun?
                                </h3>
                                <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>

                        <p className="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda benar-benar ingin menghapus akun Anda secara permanen.
                        </p>

                        <form 
                            method="POST" 
                            action="/profile" 
                            onSubmit={() => setIsDeleting(true)}
                            className="space-y-4"
                        >
                            <input type="hidden" name="_token" value={csrfToken} />
                            <input type="hidden" name="_method" value="DELETE" />

                            <div>
                                <label htmlFor="delete_password" className="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Kata Sandi Konfirmasi
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                        <Lock className="w-4 h-4" />
                                    </div>
                                    <input
                                        id="delete_password"
                                        name="password"
                                        type="password"
                                        required
                                        autoFocus
                                        value={password}
                                        onChange={(e) => setPassword(e.target.value)}
                                        placeholder="Masukkan kata sandi Anda"
                                        className="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-[#0D131F] text-slate-900 dark:text-white text-xs sm:text-sm font-medium border border-slate-200 dark:border-slate-800 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-500/20 outline-none placeholder-slate-400 dark:placeholder-slate-500"
                                    />
                                </div>
                                {deleteError && (
                                    <p className="mt-1 text-xs font-semibold text-rose-500">{deleteError}</p>
                                )}
                            </div>

                            <div className="flex items-center gap-3 pt-2">
                                <button
                                    type="button"
                                    onClick={() => setShowModal(false)}
                                    className="flex-1 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold text-xs transition-colors cursor-pointer"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    disabled={isDeleting}
                                    className="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-xs shadow-sm transition-all disabled:opacity-75 cursor-pointer"
                                >
                                    {isDeleting ? 'Menghapus...' : 'Ya, Hapus Akun'}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            )}
        </>
    );
}
