import React, { useState } from 'react';
import MainLayout from "@/Layouts/MainLayout";
import { Link } from '@inertiajs/react';
import { useForm } from '@inertiajs/react';

const Detail = ({ artikel = {}, categories = [], relatedArticles = [], topCreators = [], comments = [] }) => {
  const shareUrl = typeof window !== 'undefined' ? window.location.href : '';
  const { data, setData, post, processing, errors, reset } = useForm({
    artikel_id: artikel.id,
    content: '',
  });

  const [showCount, setShowCount] = useState(5);
  const [toastMessage, setToastMessage] = useState('');

  const submit = (e) => {
    e.preventDefault();
    post('/komentar', {
      onSuccess: () => {
        setToastMessage('Komentar berhasil dikirim!');
        reset();
        setTimeout(() => setToastMessage(''), 3000);
      }
    });
  };

  return (
    <MainLayout categories={categories}>
      <div className="container mx-auto px-4 py-8 grid md:grid-cols-3 gap-8">
        <article className="md:col-span-2">
          <div className="mb-4 text-xs text-gray-500">
            <Link href="/" className="hover:underline">Home</Link> &rsaquo; <span>{artikel.category?.name || "Berita"}</span>
          </div>

          <h1 className="text-3xl md:text-4xl font-bold text-gray-900 mb-2 leading-tight">{artikel.title}</h1>

          <div className="flex flex-wrap items-center text-sm text-gray-500 gap-2 mb-4">
            <span className="font-medium">{artikel.user?.name}</span>
            <span>•</span>
            <span>{new Date(artikel.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
            <span>•</span>
            <span>5 min read</span>
          </div>

          <div className="flex gap-3 text-sm mb-6 text-gray-600">
            <span>Bagikan:</span>
            <a href={`https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`} target="_blank" rel="noopener noreferrer" className="hover:text-blue-600">Facebook</a>
            <a href={`https://twitter.com/intent/tweet?url=${shareUrl}`} target="_blank" rel="noopener noreferrer" className="hover:text-blue-500">Twitter</a>
            <a href={`https://wa.me/?text=${shareUrl}`} target="_blank" rel="noopener noreferrer" className="hover:text-green-600">WhatsApp</a>
          </div>

          <div className="mb-6">
            <img
              src={`/storage/${artikel.image}`}
              alt={artikel.title}
              className="w-full h-auto rounded-xl object-cover shadow"
              loading="lazy"
            />
            {artikel.caption && (
              <p className="text-xs text-gray-500 mt-2 italic text-center">{artikel.caption}</p>
            )}
          </div>

          <div className="prose max-w-none text-gray-800 leading-relaxed">
            <div dangerouslySetInnerHTML={{ __html: artikel.content }} />
          </div>

          {artikel.tags?.length > 0 && (
            <div className="mt-6">
              <strong className="text-sm text-gray-600">Topik Terkait:</strong>
              <div className="mt-2 flex flex-wrap gap-2">
                {artikel.tags.map((tag, index) => (
                  <span key={index} className="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full">
                    #{tag}
                  </span>
                ))}
              </div>
            </div>
          )}

          <div className="flex justify-between items-center mt-10 pt-6 border-t">
            <Link href="/" className="text-sm text-blue-600 hover:underline">&larr; Kembali ke Beranda</Link>
            <div className="flex gap-3 text-sm text-gray-600">
              <span>Bagikan:</span>
              <a href={`https://twitter.com/intent/tweet?url=${shareUrl}`} target="_blank" rel="noopener noreferrer" className="hover:text-blue-500">Twitter</a>
              <a href={`https://wa.me/?text=${shareUrl}`} target="_blank" rel="noopener noreferrer" className="hover:text-green-600">WhatsApp</a>
            </div>
          </div>

          <section className="mt-12 border-t pt-6">
            <div className="flex items-center gap-4 mb-6">
              <button className="flex items-center gap-1 text-sm text-gray-600 hover:text-green-600">
                <svg className="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M2 10h4v8H2zM6 10h10l-1.34-5.34a1 1 0 00-.97-.66H10.4L11 2l-6 6v2z" /></svg>
                Suka
              </button>
              <button className="flex items-center gap-1 text-sm text-gray-600 hover:text-red-600">
                <svg className="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M2 10h4V2H2zM6 10h10l-1.34 5.34a1 1 0 01-.97.66H10.4L11 18l-6-6v-2z" /></svg>
                Tidak Suka
              </button>
            </div>

            <h3 className="text-lg font-semibold mb-4">Komentar Pembaca</h3>

            <form onSubmit={submit} className="mb-6">
              <textarea
                rows="4"
                placeholder="Tulis komentar kamu..."
                className="w-full p-3 border rounded-md text-sm focus:outline-none focus:ring focus:border-blue-300"
                value={data.content}
                onChange={(e) => setData('content', e.target.value)}
              ></textarea>
              {errors.content && <p className="text-sm text-red-600 mt-1">{errors.content}</p>}
              <div className="flex justify-end mt-2">
                <button
                  type="submit"
                  disabled={processing}
                  className="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition"
                >
                  Kirim Komentar
                </button>
              </div>
              {toastMessage && <p className="text-green-600 text-sm mt-2">{toastMessage}</p>}
            </form>

            <div className="space-y-6">
              {comments.length > 0 ? comments.slice(0, showCount).map((comment) => (
                <div key={comment.id} className="flex gap-3 items-start">
                  <img
                    src={
                      comment.user?.profil_pic
                        ? comment.user.profil_pic.startsWith('http')
                          ? comment.user.profil_pic // URL dari Google
                          : `/storage/${comment.user.profil_pic}` // File lokal
                        : '/default-profile.png'
                    }
                    alt={comment.user?.name}
                    className="w-10 h-10 rounded-full object-cover border shadow"
                    loading="lazy"
                  />
                  <div>
                    <p className="text-sm font-semibold text-gray-800">{comment.user?.name || 'Anonim'}</p>
                    <p className="text-sm text-gray-700">{comment.content}</p>
                    <p className="text-xs text-gray-500 mt-1">
                      {new Date(comment.created_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' })}
                    </p>
                  </div>
                </div>
              )) : (
                <p className="text-sm text-gray-500 italic">Belum ada komentar.</p>
              )}

              {comments.length > showCount && (
                <div className="text-center mt-4">
                  <button
                    onClick={() => setShowCount(showCount + 5)}
                    className="text-sm text-blue-600 hover:underline"
                  >
                    Lihat lebih banyak komentar
                  </button>
                </div>
              )}
            </div>
          </section>
        </article>

        <aside className="space-y-8 md:sticky md:top-24 h-fit">
          <div className="bg-white rounded-xl shadow p-5">
            <h3 className="font-semibold text-lg border-b pb-2 mb-3">Top Stories</h3>
            <div className="space-y-4">
              {relatedArticles.slice(0, 3).map((a) => (
                <Link key={a.id} href={`/artikel/${a.slug}`} className="flex gap-3 items-start hover:bg-gray-50 rounded-lg p-2 transition">
                  <img
                    src={`/storage/${a.image}`}
                    alt={a.title}
                    className="w-16 h-16 object-cover rounded shadow"
                    loading="lazy"
                  />
                  <div>
                    <h4 className="font-bold text-sm mb-1 line-clamp-2">{a.title}</h4>
                    <p className="text-xs text-gray-500">{a.user?.name}</p>
                  </div>
                </Link>
              ))}
            </div>
          </div>

          <div className="bg-white rounded-xl shadow p-5">
            <h3 className="font-semibold text-lg border-b pb-2 mb-3 text-center">Top Creators</h3>
            <div className="grid grid-cols-2 gap-4">
              {topCreators.slice(0, 4).map((creator) => (
                <div key={creator.id} className="flex flex-col items-center text-center">
                  <img
                    src={creator.profil_pic ? `/storage/${creator.profil_pic}` : '/default-profile.png'}
                    alt={creator.name}
                    className="w-14 h-14 rounded-full object-cover border-2 shadow"
                    loading="lazy"
                  />
                  <h2 className="text-sm font-semibold text-gray-800 mt-1">{creator.name}</h2>
                  <p className="text-xs text-gray-500 truncate">{creator.email}</p>
                </div>
              ))}
            </div>
            <div className="mt-4 text-center">
              <Link href="/creators" className="text-blue-600 text-xs hover:underline">Lihat semua</Link>
            </div>
          </div>
        </aside>
      </div>
    </MainLayout>
  );
};

export default Detail;
