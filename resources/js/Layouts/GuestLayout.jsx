import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-gray-100 py-6 sm:py-0">
            <div className="w-full max-w-md overflow-hidden bg-white px-6 py-8 shadow-md sm:rounded-lg">
            <div className="mb-6">
                <Link href="/">
                    <ApplicationLogo className="h-20 w-20  text-gray-500 mx-auto" />
                </Link>

            </div>

                {children}
            </div>
        </div>
    );
}
