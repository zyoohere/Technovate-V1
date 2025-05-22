import { useState } from 'react';

export default function Navbar({ categories }) {
  const [isOpen, setIsOpen] = useState(false);
  const [hoveredCategory, setHoveredCategory] = useState(null);

  const groupedCategories = categories.reduce((acc, category) => {
    if (!category.parent_id) {
      acc[category.id] = { ...category, subcategories: [] };
    } else {
      if (!acc[category.parent_id]) {
        acc[category.parent_id] = { subcategories: [] };
      }
      acc[category.parent_id].subcategories.push(category);
    }
    return acc;
  }, {});

  return (
    <header className="relative bg-white shadow-md z-50">
      {/* Mobile Header */}
      <div className="flex items-center justify-between px-4 py-3 md:hidden">
        <div className="flex items-center">
          <img
            src="/images/Logoicon.png"
            alt="Technovate Logo"
            className="h-10 w-10 rounded-full shadow-sm"
          />
        </div>
        <button
          onClick={() => setIsOpen(!isOpen)}
          className="text-gray-700 focus:outline-none"
          aria-label="Toggle Menu"
        >
          <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {isOpen ? (
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
            ) : (
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
            )}
          </svg>
        </button>
      </div>

      {/* Desktop Header */}
      <div className="hidden md:flex w-full items-center justify-between px-8 py-4">
        <div className="flex items-center shrink-0">
          <img
            src="/images/Logoicon.png"
            alt="Technovate Logo"
            className="h-10 w-10 rounded-full shadow-sm"
          />
        </div>

        {/* Center: Mega Menu Trigger */}
        <div className="relative flex-1 flex justify-center gap-x-10">
          {Object.values(groupedCategories).map((parent) => (
            <div
              key={parent.id}
              className="relative group"
              onMouseEnter={() => setHoveredCategory(parent)}
              onMouseLeave={() => setHoveredCategory(null)}
            >
             
              <a
                href="#"
                className="text-gray-700 font-medium hover:text-teal-500 transition"
              >
                {parent.nama}
              </a>

              {/* Mega Menu Panel */}
              {hoveredCategory?.id === parent.id && (
                <div className="absolute top-full mt-3 left-1/2 -translate-x-1/2 w-[600px] bg-white shadow-xl rounded-2xl ring-1 ring-gray-200 z-40 p-6 grid grid-cols-3 gap-4 animate-fadeIn">
                  {parent.subcategories.map((sub, idx) => (
                    <a
                      key={sub.id}
                      href="#"
                      className="block text-sm text-gray-700 hover:text-teal-500 transition"
                    >
                      {sub.nama}
                    </a>
                  ))}
                </div>
              )}
            </div>
          ))}
        </div>

        {/* Right: Search & Sign In */}
        <div className="flex items-center gap-x-4 shrink-0">
          <div className="relative">
            <input
              type="text"
              placeholder="Search..."
              className="pl-10 pr-4 py-2 w-48 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
            />
            <span className="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
          </div>
          <button className="px-5 py-2 text-white bg-teal-500 hover:bg-teal-600 rounded-full shadow-md transition">
            Sign In
          </button>
        </div>
      </div>

      {/* Mobile Dropdown */}
      {isOpen && (
        <nav className="md:hidden px-4 pt-4 pb-6 bg-white shadow-md space-y-4 border-t border-gray-100">
          <ul className="space-y-3">
            {Object.values(groupedCategories).map((parent) => (
              <li key={parent.id}>
                <a
                  href="#"
                  className="block text-gray-700 font-medium hover:text-teal-500 transition"
                >
                  {parent.nama}
                </a>
                <ul className="space-y-2 ml-4">
                  {parent.subcategories.map((sub) => (
                    <li key={sub.id}>
                      <a
                        href="#"
                        className="block text-gray-700 font-medium hover:text-teal-500 transition"
                      >
                        {sub.nama}
                      </a>
                    </li>
                  ))}
                </ul>
              </li>
            ))}
          </ul>

          <div className="relative">
            <input
              type="text"
              placeholder="Search..."
              className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm"
            />
            <span className="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
          </div>

          <button className="w-full px-4 py-2 text-white bg-teal-500 hover:bg-teal-600 rounded-full shadow-md transition">
            Sign In
          </button>
        </nav>
      )}
    </header>
  );
}
