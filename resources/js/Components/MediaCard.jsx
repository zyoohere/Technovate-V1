import React from 'react';
import { Head, usePage } from '@inertiajs/react';

export default function MediaCard() {
  const { media } = usePage().props;

  const getYouTubeEmbedUrl = (url) => {
    if (!url) return '';
    const videoId = url.includes('youtu.be/')
      ? url.split('youtu.be/')[1].split('?')[0]
      : url.split('v=')[1]?.split('&')[0];
    return videoId ? `https://www.youtube.com/embed/${videoId}` : '';
  };

  return (
    <>
      <div className="max-w-7xl mx-auto px-4 py-8">
        <div className="flex justify-between items-center mb-6">
          <h1 className="text-2xl font-bold">Video</h1>
          <a
            href="/media"
            className="text-sm text-blue-600 hover:underline font-semibold"
          >
            Lebih banyak
          </a>
        </div>

        {media.length === 0 ? (
          <p className="text-gray-500">Tidak ada media video atau external.</p>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            {media.map((item) => {
              const isExternal = item.type === 'external';
              const isVideo = item.type === 'video';

              return (
                <div
                  key={item.id}
                  className="bg-white rounded shadow hover:shadow-lg transition duration-300 overflow-hidden"
                >
                  <div className="relative aspect-video bg-black">
                    {isVideo && item.media_path && (
                      <video
                        controls
                        className="w-full h-full object-cover"
                      >
                        <source
                          src={`/storage/${item.media_path}`}
                          type="video/mp4"
                        />
                        Browser Anda tidak mendukung video.
                      </video>
                    )}

                    {isExternal && item.media_url && (
                      <iframe
                        className="w-full h-full"
                        src={getYouTubeEmbedUrl(item.media_url)}
                        title={item.title}
                        frameBorder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowFullScreen
                      ></iframe>
                    )}
                  </div>
                  <div className="p-4">
                    <h3 className="text-md font-semibold text-gray-800 leading-snug">
                      {item.caption ?? item.title ?? 'Tanpa Judul'}
                    </h3>
                  </div>
                </div>
              );
            })}
          </div>
        )}
      </div>
    </>
  );
}
