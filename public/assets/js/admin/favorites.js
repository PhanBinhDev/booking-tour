document.addEventListener('DOMContentLoaded', function() {
    // Tìm tất cả các nút yêu thích
    const favoriteBtns = document.querySelectorAll('.favorite-btn');
    
    favoriteBtns.forEach(btn => {

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = btn.querySelector('svg');
            let isFavorited = icon.classList.contains('text-red-500');
            
            const tourId = this.getAttribute('data-tour-id');

            console.log({tourId});
            // return;
            
            // Sử dụng biến URL đã được định nghĩa
            fetch(toggleFavoriteUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `tour_id=${tourId}`
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response:', text);
                        throw new Error('Lỗi mạng hoặc đường dẫn không chính xác');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Cập nhật giao diện nút dựa trên kết quả
                    if (data.action === 'added') {
                        icon.classList.remove('text-teal-500');
                        icon.classList.add('text-red-500');
                        this.setAttribute('title', 'Xóa khỏi yêu thích');
                        
                        // Hiển thị thông báo thành công
                        showToast('Đã thêm tour vào danh sách yêu thích!', 'success');
                    } else if (data.action === 'removed') {
                        icon.classList.remove('text-red-500');
                        icon.classList.add('text-teal-500');
                        this.setAttribute('title', 'Thêm vào yêu thích');
                        
                        // Hiển thị thông báo thành công
                        showToast('Đã xóa tour khỏi danh sách yêu thích', 'success');
                        
                        // Nếu đang ở trang wishlist, xóa thẻ sau một khoảng thời gian ngắn
                        if (window.location.pathname.includes('/user/wishlist')) {
                            setTimeout(() => {
                                const tourCard = this.closest('.grid > div');
                                if (tourCard) {
                                    tourCard.remove();
                                    
                                    // Nếu không còn tour yêu thích, hiển thị trạng thái trống
                                    if (document.querySelectorAll('.grid > div').length === 0) {
                                        const container = document.querySelector('.container');
                                        const grid = document.querySelector('.grid');
                                        
                                        if (grid) {
                                            grid.remove();
                                            
                                            const emptyState = document.createElement('div');
                                            emptyState.className = 'bg-gray-100 p-8 rounded-lg text-center';
                                            emptyState.innerHTML = `
                                                <h2 class="text-xl font-medium mb-4">Bạn chưa có tour yêu thích nào</h2>
                                                <p class="mb-6">Hãy xem các tour và thêm vào danh sách yêu thích!</p>
                                                <a href="${homepageUrl}" class="bg-teal-500 text-white py-3 px-6 rounded-md hover:bg-teal-600 transition">Xem các Tour</a>
                                            `;
                                            
                                            container.appendChild(emptyState);
                                        }
                                    }
                                }
                            }, 300);
                        }
                    }
                } else {
                    // Hiển thị thông báo lỗi
                    showToast(data.message || 'Đã xảy ra lỗi', 'error');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showToast('Đã xảy ra lỗi. Vui lòng thử lại.', 'error');
            });
        });
    });
    
    // Hàm hiển thị thông báo toast
    function showToast(message, type = 'success') {
        // Kiểm tra xem đã có toast container chưa
        let toastContainer = document.getElementById('toast-container');
        
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed bottom-4 right-4 z-50';
            document.body.appendChild(toastContainer);
        }
        
        const toast = document.createElement('div');
        toast.className = `py-2 px-4 rounded-md text-white ${type === 'success' ? 'bg-teal-500' : 'bg-red-500'} shadow-lg mb-2 transition-opacity duration-300`;
        toast.style.opacity = '0';
        toast.textContent = message;
        
        toastContainer.appendChild(toast);
        
        // Hiệu ứng hiện dần
        setTimeout(() => {
            toast.style.opacity = '1';
        }, 100);
        
        // Hiệu ứng mờ dần và xóa sau 3 giây
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toastContainer.removeChild(toast);
                
                // Xóa container nếu không còn toast nào
                if (toastContainer.children.length === 0) {
                    document.body.removeChild(toastContainer);
                }
            }, 300);
        }, 3000);
    }
});