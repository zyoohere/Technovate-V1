import ArtikelCard from "@/Components/ArtikelCard";
import ArtikelGrid from "@/Components/ArtikelGrid";
import HeroSection from "@/Components/HeroSection";
import MediaCard from "@/Components/MediaCard";
import MainLayout from "@/Layouts/MainLayout";



export default function Home({ artikels, media, categories }) {
    return (
        <>
        <MainLayout categories={categories}>
            <HeroSection artikels={artikels} />
            <ArtikelGrid artikels={artikels}/>
            <ArtikelCard artikels={artikels} />
            <MediaCard media={media} />
        </MainLayout>
            
        </>
    );
}