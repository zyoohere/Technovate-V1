import { Link } from '@inertiajs/react';

const HeroSection = ({ artikels }) => {
  return (
    <section className="container mx-auto px-4 py-8">
      <h3 className="text-2xl font-semibold mb-6">Popular artikels</h3>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {/* Artikel Utama */}
        {artikels.slice(0, 1).map((artikel) => (
          <div
            key={artikel.id}
            className="md:col-span-2 border rounded-lg overflow-hidden shadow-lg bg-white hover:shadow-lg transition duration-300"
          >
            <Link href={`/artikel/${artikel.slug}`}>
              <img
                src={`/storage/${artikel.image}`}
                alt={artikel.title}
                className="w-full h-64 object-cover"
              />
              <div className="p-4">
                <h2 className="text-xl font-bold mb-2">{artikel.title}</h2>
                <div className="prose max-w-none text-gray-700">
                  <div dangerouslySetInnerHTML={{ __html: artikel.excerpt }} />
                </div>
              </div>
            </Link>
          </div>
        ))}

        {/* Artikel Kecil (kanan) */}
        <div className="space-y-4">
          {artikels.slice(1, 4).map((artikel) => (
            <Link
              href={`/artikel/${artikel.slug}`}
              key={artikel.id}
              className="flex gap-4 items-start border p-4 rounded-lg hover:bg-gray-50 transition"
            >
              <img
                src={`/storage/${artikel.image}`}
                alt={artikel.title}
                className="w-20 h-20 object-cover rounded"
              />
              <div>
                <h4 className="font-bold text-lg">{artikel.title}</h4>
                <p className="text-sm text-gray-500">{artikel.user?.name}</p>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
};

export default HeroSection;
