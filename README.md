# Quy Trình Git Flow

## Tổng Quan

Quy trình **Git Flow** giúp nhóm phát triển tổ chức mã nguồn tốt hơn và dễ dàng quản lý các tính năng, sửa lỗi, và cập nhật phiên bản của dự án. Quy trình này sẽ gồm các nhánh chính như `main`, `dev`, `hotfix` và các nhánh tính năng (feature branch).

## Các Nhánh Chính

- **`main`**: Đây là nhánh chính, luôn chứa mã nguồn ổn định, sẵn sàng cho sản xuất (production).
- **`dev`**: Nhánh phát triển chung của nhóm. Tất cả các tính năng mới và sửa lỗi sẽ được phát triển trên nhánh này trước khi hợp nhất vào nhánh `main`.
- **`hotfix`**: Dùng để sửa lỗi khẩn cấp trên môi trường sản xuất mà không làm gián đoạn quá trình phát triển tính năng mới. Khi sửa lỗi xong, nhánh `hotfix` sẽ được merge vào cả `main` và `dev`.

## Các Bước Phát Triển

### 1. **Trước Khi Bắt Đầu Làm Việc**

Trước khi tạo nhánh mới cho tính năng hoặc bắt đầu sửa lỗi, bạn cần **fetch hoặc pull** mã nguồn mới nhất từ nhánh `dev` để đảm bảo rằng bạn đang làm việc trên phiên bản mới nhất của dự án.

#### Cách thực hiện:

- Fetch và cập nhật thông tin từ remote:

```bash
git pull origin main

2. Tạo Nhánh Mới Cho Tính Năng Mới (Feature Branch)
Sau khi pull xong, bạn có thể tạo một nhánh mới để phát triển tính năng. Đặt tên cho nhánh theo chức năng bạn đang phát triển.

Cách thực hiện:
Tạo một nhánh mới cho tính năng:
git checkout -b feature/ten-tinh-nang

3. Phát Triển Tính Năng Mới
Bây giờ bạn có thể bắt đầu làm việc trên tính năng mới trong nhánh vừa tạo. Khi bạn hoàn thành một phần của tính năng hoặc muốn lưu lại các thay đổi, bạn cần commit.

Cách thực hiện:
Thêm và commit các thay đổi:
git add .
git commit -m "[feat]: Thêm tính năng X"
Các prefix commit cần tuân thủ:
[feat]: Tính năng mới
[fix]: Sửa lỗi
[docs]: Cập nhật tài liệu
[style]: Thay đổi kiểu mã (chưa ảnh hưởng đến logic)
[refactor]: Cải tiến mã mà không thay đổi chức năng
[perf]: Tối ưu hiệu suất
[test]: Thêm hoặc sửa test
[chore]: Các thay đổi công cụ hoặc cấu hình
[build]: Các thay đổi ảnh hưởng đến build hoặc các công cụ phụ trợ
[ci]: Thay đổi liên quan đến cấu hình CI/CD
[revert]: Quay lại commit trước
[nit]: Các thay đổi nhỏ, chủ yếu là style hoặc syntax
[minor]: Các thay đổi nhỏ, tính năng hoặc cải tiến không phá vỡ code
[dist]: Thay đổi đến các submodules hoặc các bản cập nhật version

4. Đẩy Thay Đổi Lên Remote (Push)
Khi bạn hoàn thành tính năng và đã commit xong, bạn cần đẩy nhánh lên remote để chia sẻ với nhóm.

Cách thực hiện:
git push origin feature/ten-tinh-nang

5. Tạo Pull Request (PR)
Sau khi push xong, bạn cần tạo một Pull Request (PR) từ nhánh tính năng của bạn vào nhánh dev trên GitHub hoặc GitLab để nhóm code review và hợp nhất vào nhánh phát triển.

6. Code Review và Phản Hồi
Nhóm sẽ tiến hành review PR của bạn. Nếu có bất kỳ yêu cầu thay đổi nào, bạn cần thực hiện và đẩy lại các thay đổi đó.

Cách thực hiện:
Đảm bảo sửa lỗi hoặc cải tiến theo feedback từ code review.
Sau khi thực hiện thay đổi, commit và push lại:
git commit -m "[fix]: Sửa lỗi theo feedback"
git push origin feature/ten-tinh-nang

7. Merge Pull Request
Khi PR đã được phê duyệt, bạn có thể merge nhánh tính năng vào dev. Nếu quy trình của bạn yêu cầu một người khác thực hiện merge, bạn cần đợi họ thực hiện.

Merge vào nhánh dev sau khi PR được chấp nhận.
Kiểm tra lại code trên nhánh dev sau khi merge để đảm bảo mọi thứ hoạt động bình thường.

8. Cập Nhật Mã Từ Nhánh dev (Khi Merge Xong)
Trước khi tiếp tục làm việc với các tính năng khác hoặc deploy, bạn cần cập nhật nhánh dev của mình bằng cách pull mã nguồn mới nhất.

git checkout dev
git pull origin dev

9. Tạo Hotfix (Khi Cần)
Nếu có lỗi quan trọng cần phải sửa ngay trên môi trường sản xuất, bạn có thể tạo nhánh hotfix từ nhánh main và tiến hành sửa lỗi.

Cách thực hiện:
Tạo nhánh hotfix từ nhánh main:

git checkout main
git pull origin main
git checkout -b hotfix/sua-loi-quan-trong
Sau khi sửa lỗi, commit và push lên remote:

git commit -m "[fix]: Sửa lỗi quan trọng trên môi trường sản xuất"
git push origin hotfix/sua-loi-quan-trong
Merge nhánh hotfix vào cả main và dev.

10. Hoàn Thành và Dọn Dẹp
Sau khi tính năng đã được hoàn thành và hợp nhất vào dev, bạn có thể xóa nhánh tính năng của mình:

bash
Sao chép mã
git branch -d feature/ten-tinh-nang
git push origin --delete feature/ten-tinh-nang

#Commit Message Prefixes - Documentation

1. feat: New Features
Mô tả: Dùng khi bạn thêm một tính năng mới vào ứng dụng hoặc dự án.
Ví dụ:
feat(auth): add login functionality
feat(payment): implement stripe payment gateway

2. fix: Bug Fixes
Mô tả: Dùng khi bạn sửa một lỗi hoặc vấn đề nào đó trong code.
Ví dụ:
fix(user): resolve issue with user login
fix(button): correct color for disabled button

3. docs: Documentation
Mô tả: Dùng khi bạn cập nhật hoặc cải thiện tài liệu (README, changelog, hướng dẫn sử dụng, vv).
Ví dụ:
docs: update readme with new installation instructions
docs(api): add new API endpoints to documentation

4. style: Style Changes
Mô tả: Dùng khi bạn thay đổi phong cách mã (các thay đổi không ảnh hưởng đến logic, chẳng hạn như chỉnh sửa indent, format, vv).
Ví dụ:
style: format the button component
style: update spacing in the header component

5. refactor: Code Refactoring
Mô tả: Dùng khi bạn thay đổi cấu trúc của code mà không thay đổi hành vi của nó.
Ví dụ:
refactor(auth): simplify login function
refactor(database): improve query performance

6. perf: Performance Improvements
Mô tả: Dùng khi bạn cải thiện hiệu suất của ứng dụng hoặc mã.
Ví dụ:
perf(auth): reduce login time
perf(database): optimize data retrieval

7. test: Tests
Mô tả: Dùng khi bạn thêm hoặc sửa các test cases.
Ví dụ:
test(auth): add unit test for login functionality
test(cart): add e2e test for cart functionality

8. chore: Chores / Maintenance
Mô tả: Dùng khi bạn làm việc về công việc bảo trì hoặc nhiệm vụ không ảnh hưởng đến mã logic.
Ví dụ:
chore: update dependencies
chore: clean up old feature flags
9. build: Build System or External Dependencies

Mô tả: Dùng khi bạn thay đổi cấu hình build, hoặc các thư viện phụ thuộc bên ngoài (như webpack, package.json, Docker, vv).
Ví dụ:
build: update webpack configuration
build: bump version to 1.2.3

10. ci: Continuous Integration
Mô tả: Dùng khi bạn thay đổi cấu hình cho hệ thống CI/CD.
Ví dụ:
ci: update TravisCI config
ci: add GitHub Actions for testing

11. revert: Reverts a Previous Commit
Mô tả: Dùng khi bạn muốn hủy bỏ một commit trước đó.
Ví dụ:
revert: revert commit abc1234 (fix auth bug)
revert: undo changes made to database schema

12. nit: Small Changes (Styling, Syntax, etc.)
Mô tả: Dùng khi bạn thực hiện các thay đổi nhỏ về phong cách, cú pháp, hay mã dễ đọc hơn, không ảnh hưởng đến logic.
Ví dụ:
nit: change variable name from "data" to "userData"
nit: fix indentation in config.js

13. minor: Minor Changes
Mô tả: Dùng khi bạn thực hiện các thay đổi nhỏ hoặc cải tiến nhỏ không làm thay đổi tính năng chính của ứng dụng.
Ví dụ:
minor: update button hover state
minor: tweak color scheme for header

14. dist: Distribution / External Libraries or Modules
Mô tả: Dùng khi bạn cập nhật các mô-đun bên ngoài, các thay đổi liên quan đến phân phối, bản phát hành, hoặc package.
Ví dụ:
dist: update to version 2.3.4
dist: fix broken dependency

15. bin: Binary Files or Scripts
Mô tả: Dùng khi bạn thay đổi các file nhị phân hoặc các script liên quan đến công việc trong hệ thống.
Ví dụ:
bin: add deploy script
bin: update build script for Docker
```
