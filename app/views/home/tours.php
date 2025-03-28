<?php

use App\Helpers\UrlHelper;

$title = 'Tours - Di Travel';
$activePage = 'tours';


?>

<div class="py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="flex flex-col lg:flex-row gap-12">

            <div class="lg:w-1/4">
                <!-- ul>li categories -->
                <h3 class="text-xl font-bold mb-6 text-teal-500">Travel Categories</h3>
                <ul class="space-y-2">
                    <li class="border-l-4 border-teal-500 pl-3 py-2 bg-teal-50 text-teal-700 font-medium">All Destinations</li>
                    <?php foreach ($categories as $category) { ?>

                        <li class="border-l-4 border-transparent hover:border-teal-500 pl-3 py-2 hover:bg-teal-50 transition-colors"><?= $category['name'] ?></li>

                    <?php } ?>
                </ul>

            </div>

            <div class="lg:w-3/4">
                <!-- grid tour 4 collum -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Popular Tours</h2>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500 mr-2">Sort by:</span>
                        <select class="text-sm border border-gray-300 rounded py-1 px-2 focus:ring-teal-500 focus:border-teal-500">
                            <option>Most Popular</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Rating</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($allTours as $tour) { ?>
                        <input type="hidden" name="" id="<?= $tour["id"] ?>">

                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=300&fit=crop" alt="Beach Tour" class="w-full h-48 object-cover">
                                <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded text-red-500 font-semibold text-sm">
                                    <?= number_format($tour['price'], 0, ',', '.') . ' VND' ?>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center text-xs text-gray-500 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <?= $tour['location_name'] ?>
                                </div>
                                <a href="<?= UrlHelper::route('home/tour-details/' . $tour['id']) ?>">
                                    <h3 class="font-medium text-gray-800 mb-2"><?= $tour['title'] ?></h3>
                                </a>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-sm font-medium ml-1">4.8</span>
                                        <span class="text-xs text-gray-500 ml-1">(124)</span>
                                    </div>
                                    <button class="text-sm font-medium text-teal-500 hover:text-teal-600">View</button>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                </div>

                <!-- Pagination -->
                <div class="mt-10 flex justify-center">
                    <div class="flex space-x-1">
                        <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button class="px-3 py-2 rounded bg-teal-500 text-white">1</button>
                        <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">2</button>
                        <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">3</button>
                        <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">...</button>
                        <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">8</button>
                        <button class="px-3 py-2 rounded text-gray-600 hover:bg-teal-50 hover:text-teal-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>