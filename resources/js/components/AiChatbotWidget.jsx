import React, { useState, useRef, useEffect } from 'react';
import {
    Sparkles,
    Send,
    Camera,
    Image as ImageIcon,
    X,
    RotateCcw,
    Bot,
    User,
    CheckCircle2,
    AlertCircle,
    DollarSign,
    Scale,
    Leaf,
    Loader2
} from 'lucide-react';

export default function AiChatbotWidget() {
    const [isOpen, setIsOpen] = useState(false);
    const [messages, setMessages] = useState([
        {
            id: 'msg-welcome',
            role: 'assistant',
            text: 'Halo! Saya **SiSampah AI Vision** 🤖🌱. Saya siap membantu Anda mengenali jenis sampah melalui foto, mengecek harga pasar terkini, atau menjawab pertanyaan seputar daur ulang dan bank sampah.',
            time: 'Sekarang',
        }
    ]);
    const [inputMessage, setInputMessage] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [scanContext, setScanContext] = useState(null);
    const [previewImage, setPreviewImage] = useState(null);
    const fileInputRef = useRef(null);
    const cameraInputRef = useRef(null);
    const messagesEndRef = useRef(null);
    const inputRef = useRef(null);

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
    };

    useEffect(() => {
        if (isOpen) {
            scrollToBottom();
            setTimeout(() => inputRef.current?.focus(), 150);
        }
    }, [isOpen, messages, isLoading]);

    const quickPrompts = [
        'Berapa harga botol plastik PET hari ini?',
        'Bagaimana cara jemput sampah ke rumah?',
        'Tips membersihkan kardus sebelum disetor',
        'Bagaimana cara mencairkan saldo SiSampay?'
    ];

    const getCsrfToken = () => {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    };

    const handleSendMessage = async (textToSend = null) => {
        const text = (textToSend || inputMessage).trim();
        if (!text && !previewImage) return;

        const userMsgId = `user-${Date.now()}`;
        const userMsg = {
            id: userMsgId,
            role: 'user',
            text: text,
            image: previewImage,
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
        };

        setMessages((prev) => [...prev, userMsg]);
        setInputMessage('');
        setPreviewImage(null);
        setIsLoading(true);

        try {
            const chatHistory = messages
                .filter((m) => m.id !== 'msg-welcome')
                .map((m) => ({
                    role: m.role === 'user' ? 'user' : 'model',
                    text: m.text || '',
                }));

            const res = await fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: text,
                    history: chatHistory,
                    scan_context: scanContext,
                }),
            });

            if (res.ok) {
                const data = await res.json();
                const botReply = data.reply || 'Maaf, saya tidak dapat memahami pertanyaan tersebut saat ini.';
                setMessages((prev) => [
                    ...prev,
                    {
                        id: `bot-${Date.now()}`,
                        role: 'assistant',
                        text: botReply,
                        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                    },
                ]);
            } else {
                throw new Error('Chat API response failed');
            }
        } catch (err) {
            console.error('Chat error:', err);
            setMessages((prev) => [
                ...prev,
                {
                    id: `bot-err-${Date.now()}`,
                    role: 'assistant',
                    text: 'Koneksi AI sedang sibuk. Silakan coba kembali sesaat lagi.',
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                    isError: true,
                },
            ]);
        } finally {
            setIsLoading(false);
        }
    };

    const handleFileUpload = async (file) => {
        if (!file) return;

        const reader = new FileReader();
        reader.onload = async (e) => {
            const base64Data = e.target.result;
            
            const userMsgId = `scan-${Date.now()}`;
            setMessages((prev) => [
                ...prev,
                {
                    id: userMsgId,
                    role: 'user',
                    text: 'Memindai foto sampah...',
                    image: base64Data,
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                }
            ]);
            setIsLoading(true);

            try {
                const formData = new FormData();
                formData.append('image', file);

                const res = await fetch('/chat/vision', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (res.ok) {
                    const json = await res.json();
                    const visionData = json.data;
                    setScanContext(visionData);

                    setMessages((prev) => [
                        ...prev,
                        {
                            id: `vision-res-${Date.now()}`,
                            role: 'assistant',
                            text: visionData?.summary?.kesimpulan || 'Analisis foto sampah selesai.',
                            visionResult: visionData,
                            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        }
                    ]);
                } else {
                    throw new Error('Vision API failed');
                }
            } catch (err) {
                console.error('Vision analysis error:', err);
                setMessages((prev) => [
                    ...prev,
                    {
                        id: `bot-vision-err-${Date.now()}`,
                        role: 'assistant',
                        text: 'Gagal menganalisis foto. Pastikan foto memiliki pencahayaan yang cukup dan format gambar valid (JPG/PNG).',
                        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        isError: true,
                    }
                ]);
            } finally {
                setIsLoading(false);
            }
        };
        reader.readAsDataURL(file);
    };

    const formatMessageText = (text = '') => {
        const boldParsed = text.replace(/\*\*(.*?)\*\*/g, '<strong class="text-emerald-600 dark:text-emerald-400 font-bold">$1</strong>');
        const lines = boldParsed.split('\n');
        return lines.map((line, idx) => {
            if (line.startsWith('- ') || line.startsWith('* ')) {
                return (
                    <li key={idx} className="ml-4 list-disc text-xs sm:text-sm text-slate-700 dark:text-slate-300" dangerouslySetInnerHTML={{ __html: line.substring(2) }} />
                );
            }
            if (line.trim() === '') {
                return <div key={idx} className="h-1.5" />;
            }
            return (
                <p key={idx} className="text-xs sm:text-sm leading-relaxed text-slate-800 dark:text-slate-200" dangerouslySetInnerHTML={{ __html: line }} />
            );
        });
    };

    return (
        <div className="fixed bottom-5 right-5 sm:bottom-6 sm:right-6 z-50 select-none">
            
            {/* 1. Floating Action Trigger Button */}
            {!isOpen && (
                <div className="relative group">
                    {/* Tooltip Badge */}
                    <div className="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-white/95 dark:bg-[#111827]/95 backdrop-blur-md text-slate-800 dark:text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-lg border border-emerald-200 dark:border-emerald-800/80 pointer-events-none opacity-0 group-hover:opacity-100 transition-all duration-200 translate-x-2 group-hover:translate-x-0 whitespace-nowrap hidden sm:flex items-center gap-1.5">
                        <Sparkles className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 animate-pulse" />
                        <span>Tanya SiSampah AI</span>
                    </div>

                    {/* Pulse Glow Ring */}
                    <div className="absolute -inset-1 bg-gradient-to-r from-emerald-400 to-teal-400 dark:from-emerald-500 dark:to-teal-500 rounded-full blur-sm opacity-50 dark:opacity-70 group-hover:opacity-90 animate-pulse transition duration-300"></div>

                    {/* Main FAB */}
                    <button
                        type="button"
                        onClick={() => setIsOpen(true)}
                        className="relative w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white dark:bg-[#111827] p-1.5 shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer ring-4 ring-emerald-100 dark:ring-emerald-950/80 border-2 border-emerald-500 dark:border-emerald-400"
                        aria-label="Buka Chatbot SiSampah AI"
                    >
                        <img
                            src="/images/chatbot-icon.png"
                            alt="SiSampah AI"
                            className="w-full h-full object-contain drop-shadow-sm"
                            onError={(e) => {
                                e.target.style.display = 'none';
                            }}
                        />

                        {/* Status Green Dot */}
                        <span className="absolute top-0.5 right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full shadow-xs"></span>
                    </button>
                </div>
            )}

            {/* 2. Interactive Chat Window */}
            {isOpen && (
                <div className="w-[92vw] sm:w-[420px] h-[580px] max-h-[82vh] bg-white dark:bg-[#090D16] text-slate-800 dark:text-slate-100 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_60px_rgba(0,0,0,0.8)] border border-slate-200/90 dark:border-slate-800 flex flex-col overflow-hidden animate-slide-in transition-colors duration-200">
                    
                    {/* Header */}
                    <div className="px-4 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-950 dark:via-[#0a2e22] dark:to-teal-950 text-white flex items-center justify-between shadow-sm border-b border-emerald-500/20">
                        <div className="flex items-center gap-2.5">
                            <div className="w-9 h-9 rounded-full bg-white dark:bg-black/40 p-1 flex items-center justify-center shadow-xs border border-transparent dark:border-emerald-500/40">
                                <img
                                    src="/images/chatbot-icon.png"
                                    alt="AI Logo"
                                    className="w-full h-full object-contain"
                                    onError={(e) => { e.target.style.display = 'none'; }}
                                />
                            </div>
                            <div>
                                <div className="flex items-center gap-1.5">
                                    <h3 className="text-sm font-extrabold text-white tracking-tight">SiSampah AI</h3>
                                    <span className="text-[10px] px-1.5 py-0.2 rounded-full bg-white/20 dark:bg-emerald-500/30 text-white dark:text-emerald-300 font-bold border border-white/30 dark:border-emerald-500/40">
                                        Vision v2.5
                                    </span>
                                </div>
                                <div className="flex items-center gap-1.5 text-[10px] text-emerald-100 dark:text-emerald-400 font-medium">
                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-200 dark:bg-emerald-400 animate-ping"></span>
                                    <span>Online & Siap Membantu</span>
                                </div>
                            </div>
                        </div>

                        {/* Action Buttons */}
                        <div className="flex items-center gap-1 text-white/80 dark:text-slate-400">
                            <button
                                type="button"
                                onClick={() => {
                                    setMessages([
                                        {
                                            id: `msg-welcome-${Date.now()}`,
                                            role: 'assistant',
                                            text: 'Halo! Percakapan telah direset. Ada yang bisa saya bantu terkait pengelolaan sampah Anda?',
                                            time: 'Sekarang',
                                        }
                                    ]);
                                    setScanContext(null);
                                }}
                                className="p-1.5 rounded-lg hover:bg-white/20 dark:hover:bg-white/10 hover:text-white transition-colors cursor-pointer"
                                title="Reset Percakapan"
                            >
                                <RotateCcw className="w-4 h-4" />
                            </button>
                            <button
                                type="button"
                                onClick={() => setIsOpen(false)}
                                className="p-1.5 rounded-lg hover:bg-white/20 dark:hover:bg-white/10 hover:text-white transition-colors cursor-pointer"
                                title="Tutup"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    {/* Messages Container */}
                    <div className="flex-1 p-4 overflow-y-auto bg-[#F8FAFC] dark:bg-[#060A10] space-y-4 shadow-inner">
                        
                        {/* Render Message List */}
                        {messages.map((msg) => {
                            const isUser = msg.role === 'user';
                            return (
                                <div
                                    key={msg.id}
                                    className={`flex gap-2.5 items-start ${isUser ? 'flex-row-reverse' : 'flex-row'}`}
                                >
                                    {/* Avatar */}
                                    <div
                                        className={`w-7 h-7 rounded-full flex items-center justify-center shrink-0 shadow-xs ${
                                            isUser
                                                ? 'bg-gradient-to-br from-emerald-600 to-teal-600 text-white text-xs'
                                                : 'bg-white dark:bg-black/50 border border-emerald-200 dark:border-emerald-500/40 p-0.5'
                                        }`}
                                    >
                                        {isUser ? (
                                            <User className="w-3.5 h-3.5" />
                                        ) : (
                                            <img
                                                src="/images/chatbot-icon.png"
                                                alt="AI"
                                                className="w-full h-full object-contain"
                                                onError={(e) => { e.target.style.display = 'none'; }}
                                            />
                                        )}
                                    </div>

                                    {/* Bubble */}
                                    <div className={`max-w-[85%] space-y-1.5`}>
                                        <div
                                            className={`p-3.5 rounded-2xl text-xs sm:text-sm shadow-xs leading-relaxed ${
                                                isUser
                                                    ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-tr-none shadow-emerald-500/10'
                                                    : msg.isError
                                                    ? 'bg-rose-50 dark:bg-rose-950/80 text-rose-800 dark:text-rose-200 border border-rose-200 dark:border-rose-500/40 rounded-tl-none'
                                                    : 'bg-white dark:bg-[#111827] text-slate-800 dark:text-slate-100 border border-slate-200/90 dark:border-slate-800 rounded-tl-none'
                                            }`}
                                        >
                                            {/* Attached image preview */}
                                            {msg.image && (
                                                <div className="mb-2.5 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 max-h-40 shadow-xs">
                                                    <img
                                                        src={msg.image}
                                                        alt="Scan target"
                                                        className="w-full h-full object-cover"
                                                    />
                                                </div>
                                            )}

                                            {/* Text Content */}
                                            <div className="space-y-1">
                                                {isUser ? (
                                                    <p className="text-white text-xs sm:text-sm font-medium">{msg.text}</p>
                                                ) : (
                                                    formatMessageText(msg.text)
                                                )}
                                            </div>

                                            {/* Vision Result Card */}
                                            {msg.visionResult && (
                                                <div className="mt-3 pt-3 border-t border-slate-200/80 dark:border-slate-800 space-y-2.5">
                                                    {/* Objects detected */}
                                                    {msg.visionResult.objects?.map((obj, idx) => (
                                                        <div key={idx} className="p-2.5 rounded-xl bg-emerald-50/70 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 space-y-1.5">
                                                            <div className="flex items-center justify-between font-bold text-emerald-900 dark:text-emerald-300">
                                                                <span>{obj.nama_objek}</span>
                                                                <span className="text-[10px] px-1.5 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 font-bold border border-emerald-200 dark:border-emerald-800/80">
                                                                    {obj.kategori}
                                                                </span>
                                                            </div>
                                                            <div className="grid grid-cols-2 gap-2 text-[11px] text-slate-700 dark:text-slate-300 pt-1">
                                                                <div className="flex items-center gap-1">
                                                                    <Scale className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" />
                                                                    <span>Est. <strong>{obj.estimasi_berat_kg} kg</strong></span>
                                                                </div>
                                                                <div className="flex items-center gap-1 font-bold text-emerald-700 dark:text-amber-400">
                                                                    <DollarSign className="w-3.5 h-3.5 text-emerald-600 dark:text-amber-400" />
                                                                    <span>Rp {Number(obj.estimasi_saldo || 0).toLocaleString('id-ID')}</span>
                                                                </div>
                                                            </div>
                                                            {obj.cara_memilah && (
                                                                <p className="text-[10px] text-slate-600 dark:text-slate-400 italic pt-1 border-t border-emerald-200/60 dark:border-emerald-900/40">
                                                                    💡 {obj.cara_memilah}
                                                                </p>
                                                            )}
                                                        </div>
                                                    ))}

                                                    {/* Eco Impact */}
                                                    {msg.visionResult.eco_impact && (
                                                        <div className="p-2 rounded-lg bg-emerald-100/60 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/60 text-[10px] text-emerald-800 dark:text-emerald-300 flex items-center gap-1.5 font-medium">
                                                            <Leaf className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0" />
                                                            <span>Hemat CO₂: <strong>{msg.visionResult.eco_impact.co2_reduction_kg || 0.5} kg</strong></span>
                                                        </div>
                                                    )}
                                                </div>
                                            )}
                                        </div>

                                        <span className={`text-[9px] px-1 inline-block ${isUser ? 'text-slate-400 text-right w-full' : 'text-slate-400 dark:text-slate-500'}`}>
                                            {msg.time}
                                        </span>
                                    </div>
                                </div>
                            );
                        })}

                        {/* Loading Typing Indicator */}
                        {isLoading && (
                            <div className="flex gap-2.5 items-center text-slate-500 dark:text-slate-400">
                                <div className="w-7 h-7 rounded-full bg-white dark:bg-black/50 border border-emerald-200 dark:border-emerald-500/40 p-0.5 flex items-center justify-center shadow-xs">
                                    <Bot className="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 animate-spin" />
                                </div>
                                <div className="bg-white dark:bg-[#111827] border border-slate-200/90 dark:border-slate-800 rounded-2xl rounded-tl-none p-3 flex items-center gap-2 shadow-xs">
                                    <span className="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                    <span className="text-xs text-slate-600 dark:text-slate-300 font-medium">SiSampah AI sedang berpikir...</span>
                                </div>
                            </div>
                        )}

                        <div ref={messagesEndRef} />
                    </div>

                    {/* Quick Prompts Carousel */}
                    {messages.length <= 2 && (
                        <div className="px-3 py-2 bg-slate-100/80 dark:bg-[#0D131F] border-t border-slate-200 dark:border-slate-800 flex items-center gap-2 overflow-x-auto no-scrollbar">
                            {quickPrompts.map((q, idx) => (
                                <button
                                    key={idx}
                                    type="button"
                                    onClick={() => handleSendMessage(q)}
                                    className="px-2.5 py-1 rounded-full bg-white dark:bg-[#111827] hover:bg-emerald-50 dark:hover:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-[11px] font-semibold border border-emerald-200/80 dark:border-emerald-800/80 shadow-2xs whitespace-nowrap transition-all shrink-0 cursor-pointer"
                                >
                                    {q}
                                </button>
                            ))}
                        </div>
                    )}

                    {/* Input Bar */}
                    <div className="p-3 bg-white dark:bg-[#0D131F] border-t border-slate-200 dark:border-slate-800">
                        <form
                            onSubmit={(e) => {
                                e.preventDefault();
                                handleSendMessage();
                            }}
                            className="flex items-center gap-2"
                        >
                            {/* Hidden file inputs */}
                            <input
                                ref={fileInputRef}
                                type="file"
                                accept="image/*"
                                className="hidden"
                                onChange={(e) => {
                                    if (e.target.files?.[0]) {
                                        handleFileUpload(e.target.files[0]);
                                    }
                                }}
                            />
                            <input
                                ref={cameraInputRef}
                                type="file"
                                accept="image/*"
                                capture="environment"
                                className="hidden"
                                onChange={(e) => {
                                    if (e.target.files?.[0]) {
                                        handleFileUpload(e.target.files[0]);
                                    }
                                }}
                            />

                            {/* Camera Scan Button */}
                            <button
                                type="button"
                                onClick={() => cameraInputRef.current?.click()}
                                className="p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 hover:text-emerald-900 dark:hover:text-white hover:bg-emerald-100 dark:hover:bg-emerald-900/80 border border-emerald-200 dark:border-emerald-800/80 transition-colors cursor-pointer"
                                title="Foto Sampah Langsung"
                            >
                                <Camera className="w-4 h-4" />
                            </button>

                            {/* Gallery Upload Button */}
                            <button
                                type="button"
                                onClick={() => fileInputRef.current?.click()}
                                className="p-2.5 rounded-xl bg-slate-100 dark:bg-[#111827] text-slate-600 dark:text-slate-300 hover:text-emerald-800 dark:hover:text-white hover:bg-emerald-50 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 transition-colors cursor-pointer hidden sm:block"
                                title="Unggah dari Galeri"
                            >
                                <ImageIcon className="w-4 h-4" />
                            </button>

                            {/* Text Input */}
                            <input
                                ref={inputRef}
                                type="text"
                                value={inputMessage}
                                onChange={(e) => setInputMessage(e.target.value)}
                                placeholder="Tanya AI atau foto sampah..."
                                className="flex-1 bg-slate-50 dark:bg-[#111827] border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-xs sm:text-sm rounded-xl px-3 py-2.5 focus:outline-none focus:bg-white dark:focus:bg-[#111827] focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-950 transition-all"
                                disabled={isLoading}
                            />

                            {/* Send Button */}
                            <button
                                type="submit"
                                disabled={isLoading || !inputMessage.trim()}
                                className={`p-2.5 rounded-xl transition-all cursor-pointer ${
                                    inputMessage.trim() && !isLoading
                                        ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold hover:scale-105 shadow-md shadow-emerald-500/20'
                                        : 'bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed border border-slate-200 dark:border-slate-700'
                                }`}
                            >
                                {isLoading ? (
                                    <Loader2 className="w-4 h-4 animate-spin text-emerald-600 dark:text-emerald-400" />
                                ) : (
                                    <Send className="w-4 h-4" />
                                )}
                            </button>
                        </form>
                    </div>

                </div>
            )}

        </div>
    );
}
