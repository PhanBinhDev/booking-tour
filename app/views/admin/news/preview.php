<?php

use App\Helpers\UrlHelper;

?>

<div class="py-6 px-4 sm:px-6 lg:px-8">
  <!-- Breadcrumb -->
  <div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
          <a href="<?= UrlHelper::route('admin/dashboard') ?>"
            class="text-gray-500 hover:text-blue-600 flex items-center gap-1">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
              </path>
            </svg>
            Dashboard
          </a>
        </li>
        <li>
          <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"></path>
            </svg>
            <a href="<?= UrlHelper::route('admin/news/index') ?>"
              class="text-gray-500 hover:text-blue-600 ml-1 md:ml-2">Tin tức</a>
          </div>
        </li>
        <li aria-current="page">
          <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-500 ml-1 md:ml-2">Xem trước</span>
          </div>
        </li>
      </ol>
    </nav>
  </div>

  <!-- Page header -->
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-semibold text-gray-900">Xem trước bài viết</h1>
      <div class="flex space-x-3">
        <a href="<?= UrlHelper::route('admin/news/updateNews/' . $news['id']) ?>"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          Chỉnh sửa
        </a>
        <a href="<?= UrlHelper::route('admin/news/index') ?>"
          class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Quay lại
        </a>
      </div>
    </div>
  </div>

  <!-- Status bar -->
  <div class="bg-white shadow rounded-md mb-6">
    <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
      <div class="flex items-center">
        <span class="px-2.5 py-1 rounded-full text-xs font-medium 
                    <?= $news['status'] === 'published'
                      ? 'bg-green-100 text-green-800'
                      : ($news['status'] === 'draft'
                        ? 'bg-yellow-100 text-yellow-800'
                        : 'bg-gray-100 text-gray-800') ?>">
          <?= $news['status'] === 'published'
            ? 'Đã xuất bản'
            : ($news['status'] === 'draft'
              ? 'Bản nháp'
              : 'Đã lưu trữ') ?>
        </span>
        <span class="ml-4 text-sm text-gray-500">
          ID: <?= $news['id'] ?>
        </span>
      </div>
      <div class="flex space-x-3">
        <?php if ($news['status'] !== 'published'): ?>
          <button type="button" id="publishBtn"
            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Xuất bản
          </button>
        <?php endif; ?>
        <button type="button" id="deleteBtn"
          class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
          Xóa
        </button>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main content -->
    <div class="lg:col-span-2">
      <div class="bg-white shadow rounded-md overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Nội dung bài viết</h3>
        </div>

        <div class="p-6">
          <!-- Featured image -->
          <?php if (!empty($news['featured_image'])): ?>
            <div class="mb-6">
              <img src="<?= htmlspecialchars($news['featured_image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>"
                class="w-full h-auto object-cover rounded-lg">
            </div>
          <?php endif; ?>

          <!-- Title -->
          <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($news['title']) ?></h1>

          <!-- Meta information -->
          <div class="flex flex-wrap items-center text-sm text-gray-500 mb-6">
            <div class="flex items-center mr-4 mb-2">
              <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <?= date('d/m/Y H:i', strtotime($news['published_at'] ?? $news['created_at'])) ?>
            </div>
            <div class="flex items-center mr-4 mb-2">
              <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <?= htmlspecialchars($authorName) ?>
            </div>
            <div class="flex items-center mb-2">
              <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>
              <?= number_format($news['views']) ?> lượt xem
            </div>
          </div>

          <!-- Summary -->
          <?php if (!empty($news['summary'])): ?>
            <div class="mb-6">
              <div class="bg-gray-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-base font-medium text-gray-700">
                  <?= htmlspecialchars($news['summary']) ?>
                </p>
              </div>
            </div>
          <?php endif; ?>

          <!-- Content -->
          <div class="prose prose-blue max-w-none">
            <?php if (is_string($news['content']) && json_decode($news['content'])): ?>
              <!-- EditorJS content container -->
              <div id="editorjs-container" class="mt-5"></div>
            <?php else: ?>
              <div class="mt-5">
                <?= $news['content'] ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar content -->
    <div class="lg:col-span-1">
      <!-- Categories -->
      <div class="bg-white shadow rounded-md overflow-hidden mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Danh mục</h3>
        </div>
        <div class="p-4">
          <?php if (!empty($categories)): ?>
            <ul class="divide-y divide-gray-200">
              <?php foreach ($categories as $category): ?>
                <li class="py-2">
                  <div class="flex items-center">
                    <span class="text-blue-600 hover:text-blue-800">
                      <?= htmlspecialchars($category['name']) ?>
                    </span>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="text-gray-500 text-sm">Không có danh mục nào</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- SEO Information -->
      <div class="bg-white shadow rounded-md overflow-hidden mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Thông tin SEO</h3>
        </div>
        <div class="p-4">
          <dl>
            <div class="mb-4">
              <dt class="text-sm font-medium text-gray-500">Meta Title</dt>
              <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($news['meta_title'] ?? $news['title']) ?>
              </dd>
            </div>
            <div class="mb-4">
              <dt class="text-sm font-medium text-gray-500">Meta Description</dt>
              <dd class="mt-1 text-sm text-gray-900">
                <?= htmlspecialchars($news['meta_description'] ?? $news['summary']) ?>
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Slug</dt>
              <dd class="mt-1 text-sm text-blue-600">
                <?= htmlspecialchars($news['slug']) ?>
              </dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- Statistics -->
      <div class="bg-white shadow rounded-md overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Thống kê</h3>
        </div>
        <div class="p-4">
          <dl class="grid grid-cols-2 gap-4">
            <div class="col-span-1">
              <dt class="text-sm font-medium text-gray-500">Ngày tạo</dt>
              <dd class="mt-1 text-sm text-gray-900">
                <?= date('d/m/Y', strtotime($news['created_at'])) ?>
              </dd>
            </div>
            <div class="col-span-1">
              <dt class="text-sm font-medium text-gray-500">Cập nhật cuối</dt>
              <dd class="mt-1 text-sm text-gray-900">
                <?= date('d/m/Y', strtotime($news['updated_at'])) ?>
              </dd>
            </div>
            <div class="col-span-1">
              <dt class="text-sm font-medium text-gray-500">Lượt xem</dt>
              <dd class="mt-1 text-sm text-gray-900">
                <?= number_format($news['views']) ?>
              </dd>
            </div>
            <div class="col-span-1">
              <dt class="text-sm font-medium text-gray-500">ID</dt>
              <dd class="mt-1 text-sm text-gray-900">
                <?= $news['id'] ?>
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- EditorJS for content rendering -->
<?php if (is_string($news['content']) && json_decode($news['content'])): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Parse the EditorJS content
      try {
        const editorData = JSON.parse('<?= addslashes($news['content']) ?>');

        // Manual rendering approach instead of EditorJS instance
        const container = document.getElementById('editorjs-container');

        if (editorData && editorData.blocks) {
          editorData.blocks.forEach(block => {
            const blockElement = document.createElement('div');
            blockElement.className = 'ce-block mb-6';

            switch (block.type) {
              case 'header':
                const headerLevel = block.data.level || 2;
                const header = document.createElement(`h${headerLevel}`);
                header.textContent = block.data.text;
                header.className = 'text-gray-900 font-bold mb-4';
                if (headerLevel === 2) header.className += ' text-2xl';
                if (headerLevel === 3) header.className += ' text-xl';
                if (headerLevel === 4) header.className += ' text-lg';
                blockElement.appendChild(header);
                break;

              case 'paragraph':
                const paragraph = document.createElement('p');
                paragraph.innerHTML = block.data.text;
                paragraph.className = 'text-gray-800 mb-4 leading-relaxed';
                blockElement.appendChild(paragraph);
                break;

              case 'list':
                const list = document.createElement(block.data.style === 'ordered' ? 'ol' : 'ul');
                list.className = block.data.style === 'ordered' ? 'list-decimal pl-5' : 'list-disc pl-5';

                block.data.items.forEach(item => {
                  const listItem = document.createElement('li');
                  listItem.innerHTML = item;
                  listItem.className = 'mb-2';
                  list.appendChild(listItem);
                });

                blockElement.appendChild(list);
                break;

              case 'checklist':
                const checklist = document.createElement('div');
                checklist.className = 'ce-checklist';

                block.data.items.forEach(item => {
                  const checkItem = document.createElement('div');
                  checkItem.className = 'flex items-center mb-2';

                  const checkbox = document.createElement('div');
                  checkbox.className = item.checked ?
                    'w-4 h-4 mr-2 rounded border border-gray-400 bg-blue-500' :
                    'w-4 h-4 mr-2 rounded border border-gray-400';

                  const text = document.createElement('div');
                  text.innerHTML = item.text;
                  text.className = item.checked ? 'line-through text-gray-500' : '';

                  checkItem.appendChild(checkbox);
                  checkItem.appendChild(text);
                  checklist.appendChild(checkItem);
                });

                blockElement.appendChild(checklist);
                break;

              case 'image':
                const imageWrapper = document.createElement('div');
                imageWrapper.className = 'mb-6';

                const image = document.createElement('img');
                // Handle different image data structures
                image.src = block.data.file?.url || block.data.url || '';
                image.alt = block.data.caption || '';
                image.className = 'w-full rounded-lg';
                imageWrapper.appendChild(image);

                if (block.data.caption) {
                  const caption = document.createElement('div');
                  caption.textContent = block.data.caption;
                  caption.className = 'text-center text-gray-500 text-sm mt-2';
                  imageWrapper.appendChild(caption);
                }

                blockElement.appendChild(imageWrapper);
                break;

              case 'quote':
                const quoteWrapper = document.createElement('div');
                quoteWrapper.className = 'border-l-4 border-gray-300 pl-4 italic my-4';

                const quoteText = document.createElement('p');
                quoteText.innerHTML = block.data.text;
                quoteText.className = 'text-gray-800 mb-2';

                quoteWrapper.appendChild(quoteText);

                if (block.data.caption) {
                  const quoteCaption = document.createElement('p');
                  quoteCaption.innerHTML = '— ' + block.data.caption;
                  quoteCaption.className = 'text-gray-600 text-sm';
                  quoteWrapper.appendChild(quoteCaption);
                }

                blockElement.appendChild(quoteWrapper);
                break;

              case 'delimiter':
                const delimiter = document.createElement('hr');
                delimiter.className = 'my-6 border-gray-300';
                blockElement.appendChild(delimiter);
                break;

              case 'embed':
                const embedWrapper = document.createElement('div');
                embedWrapper.className = 'mb-6';

                if (block.data.service === 'youtube') {
                  const iframe = document.createElement('iframe');
                  iframe.width = '100%';
                  iframe.height = '400';
                  iframe.src = `https://www.youtube.com/embed/${block.data.embed}`;
                  iframe.frameBorder = '0';
                  iframe.allow =
                    'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                  iframe.allowFullscreen = true;
                  embedWrapper.appendChild(iframe);
                } else if (block.data.service === 'vimeo') {
                  const iframe = document.createElement('iframe');
                  iframe.width = '100%';
                  iframe.height = '400';
                  iframe.src = `https://player.vimeo.com/video/${block.data.embed}`;
                  iframe.frameBorder = '0';
                  iframe.allow = 'autoplay; fullscreen';
                  iframe.allowFullscreen = true;
                  embedWrapper.appendChild(iframe);
                } else {
                  const embedLink = document.createElement('a');
                  embedLink.href = block.data.embed;
                  embedLink.target = '_blank';
                  embedLink.textContent = block.data.caption || 'Embedded content';
                  embedLink.className = 'text-blue-600 hover:underline';
                  embedWrapper.appendChild(embedLink);
                }

                if (block.data.caption) {
                  const caption = document.createElement('div');
                  caption.textContent = block.data.caption;
                  caption.className = 'text-center text-gray-500 text-sm mt-2';
                  embedWrapper.appendChild(caption);
                }

                blockElement.appendChild(embedWrapper);
                break;

              case 'warning':
                const warningWrapper = document.createElement('div');
                warningWrapper.className = 'bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6';

                const warningTitle = document.createElement('p');
                warningTitle.textContent = block.data.title || 'Lưu ý';
                warningTitle.className = 'text-yellow-700 font-bold mb-2';

                const warningMessage = document.createElement('p');
                warningMessage.textContent = block.data.message || '';
                warningMessage.className = 'text-yellow-700';

                warningWrapper.appendChild(warningTitle);
                warningWrapper.appendChild(warningMessage);
                blockElement.appendChild(warningWrapper);
                break;

              default:
                const unknownBlock = document.createElement('div');
                unknownBlock.className = 'p-4 bg-gray-100 rounded-md mb-4';
                unknownBlock.textContent = `Block type "${block.type}" không được hỗ trợ`;
                blockElement.appendChild(unknownBlock);
            }

            container.appendChild(blockElement);
          });
        } else {
          container.innerHTML =
            '<div class="p-4 border border-yellow-300 bg-yellow-50 text-yellow-700 rounded">Không có nội dung để hiển thị</div>';
        }
      } catch (e) {
        console.error('Error parsing EditorJS content', e);
        document.getElementById('editorjs-container').innerHTML =
          '<div class="p-4 border border-yellow-300 bg-yellow-50 text-yellow-700 rounded">' +
          'Không thể hiển thị nội dung này</div>';
      }
    });

    // Delete confirmation
    document.getElementById('deleteBtn')?.addEventListener('click', function() {
      if (confirm('Bạn có chắc chắn muốn xóa bài viết này không?')) {
        window.location.href = '<?= UrlHelper::route('admin/news/delete/' . $news['id']) ?>';
      }
    });

    // Publish confirmation
    document.getElementById('publishBtn')?.addEventListener('click', function() {
      if (confirm('Bạn có chắc chắn muốn xuất bản bài viết này?')) {
        window.location.href = '<?= UrlHelper::route('admin/news/publish/' . $news['id']) ?>';
      }
    });
  </script>
<?php endif; ?>