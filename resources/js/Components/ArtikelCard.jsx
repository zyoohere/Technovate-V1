import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function LatestArticles() {
  const { latestArticles } = usePage().props; // pastikan data ini disediakan dari controller

  return (
    <section className="max-w-7xl mx-auto px-4 py-8">
      <div className="flex justify-between items-center mb-6">
        <h2 className="text-2xl font-bold">Berita Terbaru</h2>
        <Link
          href="/artikel"
          className="text-sm text-blue-600 hover:underline font-medium"
        >
          Lihat Semua Artikel
        </Link>
      </div>

      {latestArticles.length === 0 ? (
        <p className="text-gray-500">Belum ada artikel terbaru.</p>
      ) : (
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          {latestArticles.map((article) => (
            <Link
              href={`/artikel/${article.slug}`}
              key={article.id}
              className="bg-white rounded shadow hover:shadow-lg transition duration-300"
            >
              <div className="aspect-video overflow-hidden rounded-t">
                <img
                  src={`/storage/${article.image}`}
                  alt={article.title}
                  className="w-full h-full object-cover"
                />
              </div>
              <div className="p-4">
                <span className="inline-block mb-2 text-xs text-white bg-blue-600 px-2 py-1 rounded-full">
                  {article.category?.nama ?? 'Umum'}
                </span>
                <h3 className="text-lg font-semibold text-gray-800 leading-tight">
                  {article.title}
                </h3>
                <p className="text-sm text-gray-600 mt-2 line-clamp-3">
                  {article.excerpt ?? article.content}
                </p>
              </div>
            </Link>
          ))}
        </div>
      )}
    </section>
  );
}
