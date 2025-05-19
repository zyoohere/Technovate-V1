import { Head} from "@inertiajs/react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';


export default function HomePage() {
    return (
        <>

 <AuthenticatedLayout>
            <Head title="Home" />
            <section className="bg-gray-100 py-12">
                <div className="container mx-auto px-4 text-center">
                    <h1 className="text-3xl font-bold mb-4">Welcome to Technovate News</h1>
                    <p className="text-gray-600">Stay updated with the latest trends in technology, economy, and more.</p>
                </div>
            </section>

 </AuthenticatedLayout>
        </>
    )
}