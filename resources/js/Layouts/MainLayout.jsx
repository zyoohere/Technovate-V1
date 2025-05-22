import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { Search, Sun } from 'lucide-react';

export default function MainLayout({ children, categories = [] }) {
    const [isOpen, setIsOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const { auth } = usePage().props;
    const user = auth?.user;

    return (
        <div className="min-h-screen flex flex-col font-sans bg-light text-dark">
            {/* Header */}
            <header className="bg-white shadow sticky top-0 z-50">
                <div className="container mx-auto px-4 py-3 flex justify-between items-center">
                    <Link href="/" className="flex items-center gap-3">
                        <img src="/images/Logoicon.png" alt="Portal Logo" className="h-10 w-10 rounded-full shadow" />
                        <span className="text-2xl font-extrabold text-dark tracking-wide">Technovate</span>
                    </Link>

                    {/* Search */}
                    <div className="hidden md:flex flex-1 mx-4 max-w-xl relative">
                        <input
                            type="text"
                            placeholder="Cari tokoh, topik atau peristiwa"
                            className="w-full bg-gray-100 text-sm px-4 py-2 rounded-lg pl-10 border border-gray-300 focus:ring-2 focus:ring-primary focus:outline-none"
                        />
                        <Search className="absolute left-3 top-2.5 w-5 h-5 text-gray-500" />
                    </div>

                    {/* User Actions */}
                    <div className="hidden md:flex items-center gap-4">
                        {!user ? (
                            <>
                                <Link href="/login" className="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-lg font-semibold shadow">Masuk</Link>
                                <Link href="/register" className="text-gray-600 hover:bg-secondary px-4 py-2 rounded-lg shadow font-semibold">Daftar</Link>
                            </>
                        ) : (
                            <>
                               
                                <Sun className="w-5 h-5 text-gray-600 cursor-pointer hover:text-yellow-500" />
                                <div className="relative">
                                    <button onClick={() => setDropdownOpen(!dropdownOpen)} className="w-10 h-10 rounded-full overflow-hidden border border-gray-300">
                                        <div className="flex items-center justify-center w-full h-full bg-primary text-white font-bold">
                                            {user.name.charAt(0).toUpperCase()}
                                        </div>
                                    </button>
                                    {dropdownOpen && (
                                        <div className="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md z-50">
                                            <ul className="text-sm">
                                                <li className="px-4 py-2 hover:bg-gray-100">
                                                    <Link href="/dashboard">Dashboard</Link>
                                                </li>
                                                <li className="px-4 py-2 hover:bg-gray-100">
                                                    <Link href="/profile">Profile</Link>
                                                </li>
                                                <li className="px-4 py-2 hover:bg-gray-100 text-red-500">
                                                    <Link href="/logout" method="post" as="button" className="w-full text-left">Logout</Link>
                                                </li>
                                            </ul>
                                        </div>
                                    )}
                                </div>
                            </>
                        )}
                    </div>

                    {/* Mobile Toggle */}
                    <div className="md:hidden">
                        <button onClick={() => setIsOpen(!isOpen)} className="text-gray-700">
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {isOpen ? (
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                ) : (
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                                )}
                            </svg>
                        </button>
                    </div>
                </div>

                {/* Navigation */}
                <nav className="hidden md:flex justify-center bg-dark text-light py-2 gap-6 border-t border-gray-800">
                    {categories.map((cat) => (
                        <Link key={cat.id} href={`/kategori/${cat.slug || cat.id}`} className="hover:text-secondary font-medium transition">
                            {cat.nama}
                        </Link>
                    ))}
                </nav>

                {/* Mobile Menu */}
                {isOpen && (
                    <div className="md:hidden bg-white shadow-md px-4 pb-6 pt-4 border-t space-y-6">
                        <ul className="space-y-3">
                            {categories.map((cat) => (
                                <li key={cat.id}>
                                    <Link href={`/kategori/${cat.slug || cat.id}`} className="text-dark hover:text-primary font-medium">
                                        {cat.nama}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                        {!user ? (
                            <div className="space-y-2">
                                <Link href="/login" className="block w-full text-center px-4 py-2 bg-primary text-white rounded-lg font-semibold">
                                    Masuk
                                </Link>
                                <Link href="/register" className="block w-full text-center px-4 py-2 border border-primary rounded-lg font-semibold text-primary">
                                    Daftar
                                </Link>
                            </div>
                        ) : (
                            <div className="space-y-2">
                                <Link href="/dashboard" className="block w-full text-center px-4 py-2 bg-gray-200 rounded-lg font-semibold text-dark">
                                    Dashboard
                                </Link>
                                <Link href="/logout" method="post" as="button" className="block w-full text-center px-4 py-2 bg-red-500 text-white rounded-lg font-semibold">
                                    Logout
                                </Link>
                            </div>
                        )}
                    </div>
                )}
            </header>

            {/* Main Content */}
            <main className="flex-1 container mx-auto px-4 py-8">
                {children}
            </main>

            {/* Footer */}
            <footer className="bg-dark text-light py-10 px-4 border-t border-gray-700">
                <div className="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h2 className="text-xl font-bold text-secondary">Technovate</h2>
                        <p className="text-sm mt-2 text-neutral-300 leading-relaxed">
                            Sumber terpercaya berita teknologi, inovasi, dan highlight harian dari dunia digital.
                        </p>
                    </div>
                    <div>
                        <h3 className="text-lg font-semibold text-light mb-2">Kategori</h3>
                        <ul className="space-y-1 text-sm">
                            {categories.map((category) => (
                                <li key={category.id}>
                                    <Link href={`/kategori/${category.slug}`} className="hover:text-secondary transition">
                                        {category.nama}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                    <div>
                        <h3 className="text-lg font-semibold text-light mb-2">Perusahaan</h3>
                        <ul className="space-y-1 text-sm">
                            <li>
                                <Link href="/company-profile" className="hover:text-secondary transition">
                                    Company Profile
                                </Link>
                            </li>
                            <li>
                                <a href="mailto:support@example.com" className="hover:text-secondary transition">
                                    Kontak Kami
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div className="text-center text-xs mt-8 text-neutral-400">
                    &copy; {new Date().getFullYear()} Technovate. All rights reserved.
                </div>
            </footer>
        </div>
    );
}