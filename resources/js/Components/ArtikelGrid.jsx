import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function ArtikelGrid() {
  const { artikels } = usePage().props;

  return (
    <>
      <div className="max-w-7xl mx-auto px-4 py-8">
        <h1 className="text-2xl font-bold mb-6">Berita Terbaru</h1>

        {artikels.length === 0 ? (
          <p className="text-gray-500">Belum ada artikel tersedia.</p>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 gap-6">
            {artikels.slice(0, 3).map((artikel) => (
              <a
                key={artikel.id}
                href={`/artikel/${artikel.slug}`}
                className="relative group rounded-md overflow-hidden shadow hover:shadow-lg transition"
              >
                <img
                  src={`/storage/${artikel.image}`}
                  alt={artikel.title}
                  className="w-full h-56 object-cover"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent group-hover:from-black/90 transition"></div>
                <div className="absolute bottom-0 p-4">
                  <h2 className="text-white text-md font-semibold leading-tight line-clamp-2 drop-shadow">
                    {artikel.title}
                  </h2>
                </div>
              </a>
            ))}
          </div>
        )}
      </div>
    </>
  );
}
