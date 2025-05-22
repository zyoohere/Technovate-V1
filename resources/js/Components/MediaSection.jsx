import React, { useState } from 'react';

export default function MediaSection({ media }) {
    const [filterType, setFilterType] = useState('all');
    const [selectedMedia, setSelectedMedia] = useState(null); // ← state modal
    const [isModalOpen, setIsModalOpen] = useState(false);

    const filteredMedia = media.filter(item =>
        filterType === 'all' ? true : item.type === filterType
    );

    const openModal = (item) => {
        setSelectedMedia(item);
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setSelectedMedia(null);
        setIsModalOpen(false);
    };

    return (
        <div className="p-6 max-w-7xl mx-auto relative">
            <h1 className="text-2xl font-bold mb-4">Galeri Media</h1>

            {/* Filter */}
            <div className="mb-6 flex gap-2">
                {['all', 'image', 'video', 'document', 'external'].map(type => (
                    <button
                        key={type}
                        onClick={() => setFilterType(type)}
                        className={`px-4 py-2 rounded ${
                            filterType === type
                                ? 'bg-blue-600 text-white'
                                : 'bg-gray-200 hover:bg-gray-300'
                        }`}
                    >
                        {type.charAt(0).toUpperCase() + type.slice(1)}
                    </button>
                ))}
            </div>

            {/* Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {filteredMedia.map(item => (
                    <div
                        key={item.id}
                        className="bg-white rounded shadow overflow-hidden cursor-pointer"
                        onClick={() => openModal(item)}
                    >
                        <div className="h-48 bg-gray-100 flex items-center justify-center">
                            {item.type === 'image' && (
                                <img
                                    src={item.media_url ?? `/storage/${item.media_path}`}
                                    alt={item.title}
                                    className="w-full h-48 object-cover"
                                />
                            )}
                            {item.type === 'video' && (
                                <div className="w-full h-48 bg-black text-white flex items-center justify-center">
                                    🎥 Video - Klik untuk lihat
                                </div>
                            )}
                            {item.type === 'document' && (
                                <div className="text-center">
                                    📄 Dokumen - Klik untuk lihat
                                </div>
                            )}
                            {item.type === 'external' && (
                                <div className="text-center text-blue-500 underline">
                                    🔗 External Link
                                </div>
                            )}
                        </div>
                        <div className="p-4">
                            <h2 className="font-semibold text-lg">{item.title}</h2>
                            <p className="text-sm text-gray-600 mt-1">{item.caption}</p>
                        </div>
                    </div>
                ))}
            </div>

            {/* Modal */}
            {isModalOpen && selectedMedia && (
                <div className="fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center p-4" onClick={closeModal}>
                    <div className="bg-white rounded shadow-lg max-w-2xl w-full p-6 relative" onClick={e => e.stopPropagation()}>
                        <button
                            onClick={closeModal}
                            className="absolute top-2 right-2 text-gray-600 hover:text-black"
                        >
                            ✖
                        </button>

                        <h2 className="text-xl font-bold mb-4">{selectedMedia.title}</h2>

                        {selectedMedia.type === 'image' && (
                            <img
                                src={selectedMedia.media_url ?? `/storage/${selectedMedia.media_path}`}
                                alt={selectedMedia.title}
                                className="w-full rounded"
                            />
                        )}
                        {selectedMedia.type === 'video' && (
                            selectedMedia.media_url?.includes('youtube') ? (
                                <iframe
                                    src={selectedMedia.media_url}
                                    className="w-full h-96"
                                    frameBorder="0"
                                    allowFullScreen
                                ></iframe>
                            ) : (
                                <video controls className="w-full h-96">
                                    <source src={selectedMedia.media_url ?? `/storage/${selectedMedia.media_path}`} />
                                </video>
                            )
                        )}
                        {selectedMedia.type === 'document' && (
                            <a
                                href={selectedMedia.media_url ?? `/storage/${selectedMedia.media_path}`}
                                target="_blank"
                                className="text-blue-500 underline"
                            >
                                Buka dokumen
                            </a>
                        )}
                        {selectedMedia.type === 'external' && (
                            <a
                                href={selectedMedia.media_url}
                                target="_blank"
                                className="text-blue-500 underline"
                            >
                                Kunjungi tautan
                            </a>
                        )}
                        <p className="mt-4 text-sm text-gray-600">{selectedMedia.caption}</p>
                    </div>
                </div>
            )}
        </div>
    );
}
