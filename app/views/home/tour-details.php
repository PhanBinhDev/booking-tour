<div class="bg-gray-50 py-10">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Breadcrumbs -->
        <div class="mb-6 text-sm text-gray-500">
            <a href="#" class="hover:text-teal-500">Home</a> &gt;
            <a href="#" class="hover:text-teal-500">Tours</a> &gt;
            <span class="text-gray-700"><?= $tourDetails['title'] ?></span>
        </div>

        <!-- Tour Title Section -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2"><?= $tourDetails['title'] ?></h1>
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span><?= $tourDetails["location_name"] ?></span>
                </div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="font-medium">4.8</span>
                    <span class="text-gray-500 ml-1">(124 reviews)</span>
                </div>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><?= $tourDetails["duration"] ?></span>
                </div>
            </div>
        </div>

        <!-- Image Gallery Slideshow -->
        <div style="margin-bottom: 2rem;">
            <div class="grid grid-cols-4 grid-rows-2 gap-2 h-[500px]">
                <div class="col-span-2 row-span-2 relative">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&h=600&fit=crop" alt="Bali Beach" class="w-full h-full object-cover rounded-l-lg" />
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1544550581-5f7ceaf7f992?w=400&h=250&fit=crop" alt="Resort Pool" class="w-full h-full object-cover" />
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?w=400&h=250&fit=crop" alt="Resort Restaurant" class="w-full h-full object-cover rounded-tr-lg" />
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400&h=250&fit=crop" alt="Luxury Room" class="w-full h-full object-cover" />
                </div>
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?w=400&h=250&fit=crop" alt="Beach Activities" class="w-full h-full object-cover rounded-br-lg" />
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-br-lg">
                        <button class="bg-white text-gray-800 px-4 py-2 rounded-lg font-medium">View All Photos</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Tour Details -->
            <div class="lg:col-span-2">
                <!-- Overview Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tour Overview</h2>
                    <p class="text-gray-600 mb-4">
                        <?= $tourDetails["description"] ?>
                    </p>
                    <p class="text-gray-600 mb-4">
                        <?= $tourDetails["content"] ?>
                    </p>

                    <!-- Highlights -->
                    <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">Dịch vụ</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">

                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span><?= $tourDetails["included"] ?></span>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM12.707 7.293a1 1 0 00-1.414 0L10 8.586 8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
                            <span><?= $tourDetails["excluded"] ?></span>
                        </div>

                    </div>
                </div>

                <!-- Itinerary Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Itinerary</h2>

                    <!-- Day 1 -->
                    <div class="mb-6 border-l-4 border-teal-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Day 1: Arrival & Welcome</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Airport pickup and private transfer to resort</li>
                            <li>• Welcome drink and resort orientation</li>
                            <li>• Evening welcome dinner on the beach</li>
                        </ul>
                    </div>

                    <!-- Day 2 -->
                    <div class="mb-6 border-l-4 border-teal-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Day 2: Beach & Relaxation</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Breakfast at the beachfront restaurant</li>
                            <li>• Morning yoga session</li>
                            <li>• Free time for beach activities</li>
                            <li>• Afternoon spa treatment</li>
                            <li>• Dinner at your leisure</li>
                        </ul>
                    </div>

                    <!-- Day 3 -->
                    <div class="mb-6 border-l-4 border-teal-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Day 3: Cultural Exploration</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Breakfast at the resort</li>
                            <li>• Guided tour to Uluwatu Temple</li>
                            <li>• Traditional Balinese lunch</li>
                            <li>• Visit to local craft villages</li>
                            <li>• Evening Kecak fire dance performance</li>
                        </ul>
                    </div>

                    <!-- Show More Button -->
                    <button class="flex items-center text-teal-500 font-medium hover:text-teal-600 transition-colors">
                        <span>View Full Itinerary</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Accommodation Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Accommodation</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Room Type 1 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=500&h=300&fit=crop" alt="Deluxe Ocean View Room" class="w-full h-48 object-cover" />
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">Deluxe Ocean View Room</h3>
                                <ul class="text-sm text-gray-600 space-y-1 mb-3">
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        King-size bed
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Private balcony
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Ocean view
                                    </li>
                                </ul>
                                <div class="text-right">
                                    <span class="text-teal-500 font-semibold">Included in package</span>
                                </div>
                            </div>
                        </div>

                        <!-- Room Type 2 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500&h=300&fit=crop" alt="Beach Villa" class="w-full h-48 object-cover" />
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">Beach Villa</h3>
                                <ul class="text-sm text-gray-600 space-y-1 mb-3">
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Separate living area
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Private plunge pool
                                    </li>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Direct beach access
                                    </li>
                                </ul>
                                <div class="text-right">
                                    <span class="text-gray-600 font-semibold">+$899 upgrade</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Reviews</h2>
                        <div class="flex items-center">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <span class="ml-2 font-semibold">4.8 out of 5</span>
                        </div>
                    </div>

                    <!-- Review Filters -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <button class="bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-medium">All Reviews</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">5 Star</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">4 Star</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">3 Star</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">2 Star</button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium transition-colors">1 Star</button>
                    </div>

                    <!-- Individual Reviews -->
                    <div class="space-y-6">
                        <!-- Review 1 -->
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden mr-3">
                                        <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="Sarah J." class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Sarah J.</h4>
                                        <p class="text-sm text-gray-500">Visited April 2023</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-3">
                                Absolutely amazing experience! The resort exceeded all our expectations. The staff was incredibly attentive, the beach was pristine, and the food was outstanding. We particularly enjoyed the cultural excursions which gave us a deeper appreciation of Balinese culture.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Great Service</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Beautiful Location</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Excellent Food</span>
                            </div>
                        </div>

                        <!-- Review 2 -->
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden mr-3">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael T." class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Michael T.</h4>
                                        <p class="text-sm text-gray-500">Visited March 2023</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-3">
                                My wife and I had a wonderful time at the resort. The beach villa upgrade was definitely worth it! The private pool and direct beach access made our honeymoon truly special. The only minor issue was occasional slow service at the main restaurant during peak hours.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Romantic</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Luxury</span>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">Great Views</span>
                            </div>
                        </div>

                        <!-- Show More Reviews Button -->
                        <button class="w-full py-2 border border-teal-500 text-teal-500 rounded-lg font-medium hover:bg-teal-50 transition-colors">
                            Show More Reviews
                        </button>
                    </div>
                </div>

                <!-- Map & Location Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Location</h2>
                    <div class="aspect-video bg-gray-200 rounded-lg mb-4 overflow-hidden">
                        <!-- Map placeholder - in a real implementation, this would be an actual map -->
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <img src="https://maps.googleapis.com/maps/api/staticmap?center=Nusa+Dua,Bali,Indonesia&zoom=13&size=600x300&maptype=roadmap&markers=color:red%7CNusa+Dua,Bali,Indonesia&key=YOUR_API_KEY" alt="Map of Resort Location" class="w-full h-full object-cover" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Address</h3>
                            <p class="text-gray-600 mb-4">
                                Jl. Pantai Mengiat, Nusa Dua<br />
                                Bali 80363, Indonesia
                            </p>
                            <h3 class="font-semibold text-gray-800 mb-2">Nearby Attractions</h3>
                            <ul class="text-gray-600 space-y-1">
                                <li>• Nusa Dua Beach (0.1 km)</li>
                                <li>• Bali Collection Shopping Center (1.5 km)</li>
                                <li>• Water Blow (2.3 km)</li>
                                <li>• Puja Mandala (3.1 km)</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Getting There</h3>
                            <ul class="text-gray-600 space-y-1 mb-4">
                                <li>• Ngurah Rai International Airport (13 km)</li>
                                <li>• Airport transfer included in package</li>
                                <li>• Taxi service available 24/7</li>
                            </ul>
                            <button class="text-teal-500 font-medium hover:text-teal-600 transition-colors flex items-center">
                                <span>Get Directions</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Booking & Info -->
            <div class="lg:col-span-1">
                <!-- Pricing Card -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6 top-6">
                    <?php $tourDetails['sale_price'] ? '
                        <div class=" bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold w-20">
                            25% OFF
                        </div>
                        ' :  0 ?>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-baseline">
                            <span class="text-xl font-bold text-red-500"><?= number_format($tourDetails['sale_price'] ?? $tourDetails['price'], 0, ',', '.') . ' VND' ?></span>
                            <span class="text-gray-500 ml-2">per person</span>
                        </div>

                    </div>
                    <div class="text-gray-500 line-through mb-4"><?php $tourDetails['sale_price'] ? number_format($tourDetails['price'], 0, ',', '.') . ' VND' . 'regular price' :  0 ?> </div>

                    <!-- Date Selection -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Select Dates</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="relative">
                                <input type="text" placeholder="Check-in" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute right-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Check-out" class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute right-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Guests Selection -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Guests</label>
                        <div class="relative">
                            <select class="w-full border border-gray-300 rounded-lg py-2 px-3 appearance-none focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <option>1 Adult</option>
                                <option>2 Adults</option>
                                <option>2 Adults, 1 Child</option>
                                <option>2 Adults, 2 Children</option>
                                <option>3 Adults</option>
                                <option>4 Adults</option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute right-3 top-2.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="border-t border-b border-gray-200 py-4 mb-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Base price</span>
                            <span class="text-gray-800"><?= number_format($tourDetails['sale_price'] ?? $tourDetails['price'], 0, ',', '.') . ' VND' ?></span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Discount</span>
                            <span class="text-red-500">-500.000 VND</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Taxes & fees</span>
                            <span class="text-gray-800">300.000 VND</span>
                        </div>
                        <div class="flex justify-between font-bold mt-3 pt-3 border-t border-gray-200">
                            <span>Total</span>
                            <span>$1,624</span>
                        </div>
                    </div>

                    <!-- Booking Buttons -->
                    <div class="space-y-3">
                        <button class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 flex justify-center items-center">
                            Book Now
                        </button>
                        <div class="flex gap-2">
                            <button class="flex-1 border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-3 px-4 rounded-lg transition duration-300">
                                Reserve
                            </button>
                            <button class="border border-teal-500 text-teal-500 hover:bg-teal-50 font-semibold py-3 px-3 rounded-lg transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- What's Included Card -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">What's Included</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">7 days, 6 nights accommodation</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Airport transfers</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Daily breakfast and dinner</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">3 guided excursions</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">1 spa treatment per person</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600">Access to all resort facilities</span>
                        </li>
                    </ul>
                </div>

                <!-- Need Help Card -->
                <div class="bg-teal-50 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Need Help?</h3>
                    <p class="text-gray-600 mb-4">
                        Our travel experts are ready to assist you with any questions about this tour package.
                    </p>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Call us at</p>
                            <p class="font-medium text-gray-800">+1 (800) 123-4567</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5   stroke-linejoin=" round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email us at</p>
                            <p class="font-medium text-gray-800">support@travelagency.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Tours Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Có thể bạn quan tâm</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Similar Tour 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500&h=300&fit=crop" alt="Luxury Retreat" class="w-full h-full object-cover" />
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg text-teal-500 font-semibold text-sm">
                            $2,999
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs text-gray-500">Maldives</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Maldives Overwater Villa</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium ml-1">4.9</span>
                                <span class="text-xs text-gray-500 ml-1">(86)</span>
                            </div>
                            <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                        </div>
                    </div>
                </div>

                <!-- Similar Tour 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1533105079780-92b9be482077?w=500&h=300&fit=crop" alt="Cultural Tour" class="w-full h-full object-cover" />
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg text-teal-500 font-semibold text-sm">
                            $1,799
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs text-gray-500">Japan</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Japan Cultural Experience</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium ml-1">4.8</span>
                                <span class="text-xs text-gray-500 ml-1">(112)</span>
                            </div>
                            <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                        </div>
                    </div>
                </div>

                <!-- Similar Tour 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=500&h=300&fit=crop" alt="Mountain Tour" class="w-full h-full object-cover" />
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg text-teal-500 font-semibold text-sm">
                            $1,599
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs text-gray-500">Switzerland</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Swiss Alps Adventure</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium ml-1">4.7</span>
                                <span class="text-xs text-gray-500 ml-1">(94)</span>
                            </div>
                            <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                        </div>
                    </div>
                </div>

                <!-- Similar Tour 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-48">
                        <img src="https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=500&h=300&fit=crop" alt="Rome Tour" class="w-full h-full object-cover" />
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg text-teal-500 font-semibold text-sm">
                            $1,299
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs text-gray-500">Italy</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Italian Heritage Tour</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium ml-1">4.6</span>
                                <span class="text-xs text-gray-500 ml-1">(78)</span>
                            </div>
                            <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php var_dump($tourDetails) ?>