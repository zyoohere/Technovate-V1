import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import { Link } from '@inertiajs/react';

export default function ListDetail({ category, artikels,categories}) {
    return (
        <MainLayout categories={categories}>
            <div className="space-y-6">
                <h1 className="text-3xl font-bold text-gray-800 border-b pb-2">
                    Kategori: {category.nama}
                </h1>

                {artikels.length > 0 ? (
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {artikels.map((artikel) => (
                            <Link key={artikel.id} href={`/artikel/${artikel.slug}`} className="block border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                                <img src={`/storage/${artikel.image}`} alt={artikel.title} className="w-full h-48 object-cover" />
                                <div className="p-4">
                                    <h2 className="text-lg font-semibold text-gray-800">{artikel.title}</h2>
                                    <p className="text-sm text-gray-600 mt-2">{artikel.excerpt}</p>
                                </div>
                            </Link>
                        ))}
                    </div>
                ) : (
                    <p className="text-gray-600">Belum ada artikel dalam kategori ini.</p>
                )}
            </div>
        </MainLayout>
    );
}
