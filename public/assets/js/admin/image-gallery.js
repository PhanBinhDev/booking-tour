// Helper function to format file size
function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return Number.parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

document.addEventListener('DOMContentLoaded', () => {
  // Upload Modal
  const uploadModal = document.getElementById('upload-modal')
  const uploadBtn = document.getElementById('upload-btn')
  const emptyUploadBtn = document.getElementById('empty-upload-btn')
  const uploadCancelBtn = document.getElementById('upload-cancel-btn')
  const uploadForm = document.getElementById('upload-form')
  const fileInput = document.getElementById('file-input')
  const dropzone = document.getElementById('dropzone')
  const dropzoneText = document.getElementById('dropzone-text')
  const previewContainer = document.getElementById('preview-container')
  const imagePreview = document.getElementById('image-preview')
  const removePreviewBtn = document.getElementById('remove-preview')

  // Edit Modal
  const editModal = document.getElementById('edit-modal')
  const editBtns = document.querySelectorAll('.edit-image-btn')
  const editCancelBtn = document.getElementById('edit-cancel-btn')

  // Delete Modal
  const deleteModal = document.getElementById('delete-modal')
  const deleteBtns = document.querySelectorAll('.delete-image-btn')
  const deleteConfirmBtn = document.getElementById('delete-confirm-btn')
  const deleteCancelBtn = document.getElementById('delete-cancel-btn')

  // Featured Modal
  const featuredModal = document.getElementById('featured-modal')
  const featuredBtns = document.querySelectorAll('.set-featured-btn')
  const featuredConfirmBtn = document.getElementById('featured-confirm-btn')
  const featuredCancelBtn = document.getElementById('featured-cancel-btn')

  // Copy URL buttons
  const copyUrlBtns = document.querySelectorAll('.copy-url-btn')

  // Show Upload Modal
  function showUploadModal() {
    uploadModal.classList.remove('hidden')
    document.body.classList.add('overflow-hidden')
  }

  // Hide Upload Modal
  function hideUploadModal() {
    uploadModal.classList.add('hidden')
    document.body.classList.remove('overflow-hidden')
    uploadForm.reset()
    dropzoneText.classList.remove('hidden')
    previewContainer.classList.add('hidden')
  }

  // Show Edit Modal
  // Hide Edit Modal

  // Show Delete Modal
  function showDeleteModal(id) {
    document.getElementById('delete-id').value = id
    deleteModal.classList.remove('hidden')
    document.body.classList.add('overflow-hidden')
  }

  // Hide Delete Modal
  function hideDeleteModal() {
    deleteModal.classList.add('hidden')
    document.body.classList.remove('overflow-hidden')
  }

  // Show Featured Modal
  function showFeaturedModal(id, tourId) {
    document.getElementById('featured-image-id').value = id
    document.getElementById('featured-tour-id').value = tourId
    featuredModal.classList.remove('hidden')
    document.body.classList.add('overflow-hidden')
  }

  // Hide Featured Modal
  function hideFeaturedModal() {
    featuredModal.classList.add('hidden')
    document.body.classList.remove('overflow-hidden')
  }

  // Handle file input change
  fileInput?.addEventListener('change', (e) => {
    const file = e.target.files[0]
    if (file) {
      // Check file type
      if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
        alert('Chỉ chấp nhận file JPG, PNG hoặc GIF.')
        fileInput.value = ''
        return
      }

      // Check file size (5MB max)
      if (file.size > 5 * 1024 * 1024) {
        alert('Kích thước file không được vượt quá 5MB.')
        fileInput.value = ''
        return
      }

      // Set title if empty
      const titleInput = document.getElementById('title')
      if (!titleInput.value) {
        titleInput.value = file.name.split('.').slice(0, -1).join('.')
      }

      // Show preview
      const reader = new FileReader()
      reader.onload = (e) => {
        imagePreview.src = e.target.result
        dropzoneText.classList.add('hidden')
        previewContainer.classList.remove('hidden')
      }
      reader.readAsDataURL(file)
    }
  })

  // Handle remove preview button
  removePreviewBtn?.addEventListener('click', (e) => {
    e.preventDefault()
    e.stopPropagation()

    // Clear file input
    fileInput.value = ''

    // Hide preview, show dropzone text
    dropzoneText.classList.remove('hidden')
    previewContainer.classList.add('hidden')
  })

  // Handle drag and drop
  ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach((eventName) => {
    dropzone?.addEventListener(eventName, preventDefaults, false)
  })

  function preventDefaults(e) {
    e.preventDefault()
    e.stopPropagation()
  }
  ;['dragenter', 'dragover'].forEach((eventName) => {
    dropzone?.addEventListener(eventName, highlight, false)
  })
  ;['dragleave', 'drop'].forEach((eventName) => {
    dropzone?.addEventListener(eventName, unhighlight, false)
  })

  function highlight() {
    dropzone.classList.add('border-teal-500')
    dropzone.classList.add('bg-teal-50')
  }

  function unhighlight() {
    dropzone.classList.remove('border-teal-500')
    dropzone.classList.remove('bg-teal-50')
  }

  dropzone?.addEventListener('drop', handleDrop, false)

  function handleDrop(e) {
    const dt = e.dataTransfer
    const files = dt.files

    if (files.length > 0) {
      fileInput.files = files
      const event = new Event('change')
      fileInput.dispatchEvent(event)
    }
  }

  // Copy URL to clipboard
  copyUrlBtns.forEach((btn) => {
    btn.addEventListener('click', function () {
      const url = this.getAttribute('data-url')
      navigator.clipboard.writeText(url).then(
        () => {
          alert('Đã sao chép URL vào clipboard!')
        },
        () => {
          alert('Không thể sao chép URL. Vui lòng thử lại.')
        }
      )
    })
  })

  // Event listeners for modals
  uploadBtn?.addEventListener('click', showUploadModal)
  emptyUploadBtn?.addEventListener('click', showUploadModal)
  uploadCancelBtn?.addEventListener('click', hideUploadModal)

  editBtns.forEach((btn) => {
    btn.addEventListener('click', function () {
      const imageId = this.getAttribute('data-id')
      const baseUrl = this.getAttribute('data-url') || window.location.pathname
      // Chuyển hướng đến trang edit với ID hình ảnh
      window.location.href = `${baseUrl}/edit/${imageId}`
    })
  })
  editCancelBtn?.addEventListener('click', () => {})

  deleteBtns.forEach((btn) => {
    btn.addEventListener('click', function () {
      const action = this.getAttribute('data-base-url')
      // Cập nhật action của form với ID hình ảnh
      document.getElementById('delete-form').action = `${action}`

      console.log(document.getElementById('delete-form'))
      showDeleteModal()
    })
  })
  deleteCancelBtn?.addEventListener('click', hideDeleteModal)

  featuredBtns.forEach((btn) => {
    btn.addEventListener('click', function () {
      const imageId = this.getAttribute('data-id')
      const tourId = this.getAttribute('data-tour-id')
      showFeaturedModal(imageId, tourId)
    })
  })
  featuredCancelBtn?.addEventListener('click', hideFeaturedModal)

  // Close modals when clicking outside
  window.addEventListener('click', (e) => {
    if (e.target === uploadModal) {
      hideUploadModal()
    }
    if (e.target === deleteModal) {
      hideDeleteModal()
    }
    if (e.target === featuredModal) {
      hideFeaturedModal()
    }
  })
})
