CREATE TABLE categories(
    id int PRIMARY KEY,
    name VARCHAR(255),
    parent int,
    url_image VARCHAR(255)
);
INSERT INTO `categories` (`id`, `name`, `parent`, `url_image`) VALUES
(1, 'Thuốc', 0, 'thuoc_icon24.png'),
(2, 'Vitamin và khoáng chất', 1, ''),
(3, 'Dinh dưỡng và bổ sung dinh dưỡng', 1, ''),
(4, 'Hệ thần kinh trung ương', 1, ''),
(5, 'Sức khỏe tim mạch', 1, ''),
(6, 'Chăm sóc sức khỏe chung', 1, ''),
(7, 'Thực phẩm chức năng', 0, 'tpcn_icon24.png'),
(8, 'Hỗ trợ tiêu hóa', 7, ''),
(9, 'Dinh dưỡng', 7, ''),
(10, 'Sinh lý - Nội tiết tố', 7, ''),
(11, 'Hỗ trợ điều trị', 7, ''),
(13, 'Chăm sóc da', 0, 'csd_icon24.png'),
(14, 'Chăm sóc da mặt', 13, ''),
(15, 'Chăm sóc da tay và chân', 13, ''),
(16, 'Kem chống nắng và phụ kiện chống nắng', 13, ''),
(17, 'Chăm sóc da sau khi tắm', 13, ''),
(18, 'Chăm sóc da toàn thân', 13, ''),
(19, 'Chăm sóc tóc', 0, 'cst_icon24.png'),
(20, 'Chăm sóc tóc cho nam và nữ', 19, ''),
(21, 'Sản phẩm chống rụng tóc và kích thích mọc tóc', 19, ''),
(22, 'Sản phẩm dưỡng tóc chuyên sâu', 19, ''),
(23, 'Sản phẩm uốn và duỗi tóc', 19, ''),
(24, 'Sản phẩm chăm sóc tóc cho trẻ em', 19, ''),
(25, 'Chăm sóc cá nhân', 0, 'cscn_icon24.png'),
(26, 'Chăm sóc răng miệng và hàm răng', 25, ''),
(27, 'Sản phẩm vệ sinh phụ nữ', 25, ''),
(28, 'Sản phẩm giảm mùi cơ thể và khử mùi', 25, ''),
(29, 'Sản phẩm tắm và chăm sóc cơ thể', 25, ''),
(30, 'Sản phẩm chăm sóc cá nhân cho nam', 25, ''),
(31, 'Chăm sóc trẻ em', 0, 'cste_icon24.png'),
(32, 'Chăm sóc da và tóc cho trẻ sơ sinh', 31, ''),
(33, 'Sản phẩm chăm sóc da cho trẻ em', 31, ''),
(34, 'Sản phẩm chăm sóc tóc cho trẻ em', 31, ''),
(35, 'Sản phẩm chăm sóc răng miệng cho trẻ em', 31, ''),
(36, 'Sản phẩm dinh dưỡng cho trẻ em', 31, '');


INSERT INTO `form_products` (`id`, `name`) VALUES
(1, 'Tuýp'),
(2, 'Chai'),
(3, 'Hộp'),
(4, 'Hộp gói'),
(5, 'Hộp ống'),
(6, 'Hộp vỉ viên');

INSERT INTO `products` (`id`, `id_cate`, `id_form`, `type_price`, `class`, `name`, `description`, `price`, `total_number`, `numberone`, `numbertwo`) VALUES
(0001, 19, 1, 1, 1, 'Kem La Roche-Posay Cicaplast Baume B5 phục hồi, làm dịu da khô, da kích ứng (40ml)', 'mota',390000, 100, 1, 0 ),
(0002, 19, 2, 1, 1, 'Thuốc Espumisan L Menarini điều trị chứng đầy hơi ở trẻ dưới 3 tháng tuổi (30ml)', 'mota',56000, 50, 1, 0),
(0003, 19, 3, 1, 1, 'Bột Cần Tây nguyên chất Datino hỗ trợ giảm cholesterol xấu trong máu (3g x 15 gói)', 'mota',6000, 50, 1, 0),
(0004, 19, 4, 1, 1, 'Dầu gội thảo mộc Ohbama gội là nâu (10 gói)', 'mota',256000, 50, 12, 0),
(0005, 19, 6, 1, 1, 'Serum NNO Vite Aplicapz MEGA We care hỗ trợ dưỡng da trắng sáng (3 vỉ x 10 viên)', 'mota',2500, 50, 3, 10),
(0006, 19, 2, 2, 1, 'Thuốc Espumisan L Menarini điều trị chứng đầy hơi ở trẻ dưới 3 tháng tuổi (30ml)', 'mota',56000, 50, 1, 0),
(0007, 19, 3, 1, 1, 'Bột Cần Tây nguyên chất Datino hỗ trợ giảm cholesterol xấu trong máu (3g x 15 gói)', 'mota',6000, 50, 1, 0),
(0008, 19, 4, 1, 1, 'Dầu gội thảo mộc Ohbama gội là nâu (10 gói)', 'mota',256000, 50, 12, 0),
(0009, 19, 6, 1, 2, 'Serum NNO Vite Aplicapz MEGA We care hỗ trợ dưỡng da trắng sáng (3 vỉ x 10 viên)', 'mota',2500, 50, 3, 10);
(0010, 19, 5, 1, 2, 'Dung dịch Letbaby Hataphar phòng ngừa thiếu calci (20 ống x 5ml)', 'mota',7700, 50, 20, 0),
(0011, 19, 6, 1, 2, 'Serum NNO Vite Aplicapz MEGA We care hỗ trợ dưỡng da trắng sáng (3 vỉ x 10 viên)', 'mota',2500, 50, 3, 10);
(0012, 19, 3, 1, 2, 'Thuốc Pokemine 50mg Medisun hỗ trợ bổ sung sắt (20 ống x 10ml)', 'mota',156000, 50, 1, 0),
(0013, 19, 5, 1, 2, 'Dung dịch Letbaby Hataphar phòng ngừa thiếu calci (20 ống x 5ml)', 'mota',7700, 50, 20, 0),
(0014, 19, 6, 1, 2, 'Serum NNO Vite Aplicapz MEGA We care hỗ trợ dưỡng da trắng sáng (3 vỉ x 10 viên)', 'mota',2500, 50, 3, 10);
(0015, 19, 3, 1, 2, 'Thuốc Pokemine 50mg Medisun hỗ trợ bổ sung sắt (20 ống x 10ml)', 'mota',156000, 50, 1, 0),
(0016, 19, 3, 1, 2, 'Thuốc Pokemine 50mg Medisun hỗ trợ bổ sung sắt (20 ống x 10ml)', 'mota',156000, 50, 1, 0);


INSERT INTO `images` (`id_prod`, `url`) VALUES 
('648466', 'kemla.jpg'),
('00002', 'thuoces.jpg'),
('00003', 'botcantay.jpg'),
('00004', 'daugoi.jpg'),
('00005', 'serum.jpg'),
('00006', 'kemla.jpg'),
('00007', 'thuoces.jpg'),
('00008', 'botcantay.jpg'),
('00009', 'daugoi.jpg'),
('00010', 'letbaby.jpg'),
('00011', 'serum.jpg'),
('00012', 'pokemine.jpg'),
('00013', 'letbaby.jpg'),
('00014', 'serum.jpg'),
('00015', 'pokemine.jpg');


INSERT INTO `postcates` (`title`) VALUES 
('Dinh dưỡng'),
('Phòng chữa bệnh'),
('Người cao tuổi'),
('Tin sức khỏe');

INSERT INTO `posts` (`id`, `id_cate`, `title`, `img_title`, `created_at`, `updated_at`) VALUES 
(NULL, '1', 'Ăn cháo liên tục có tốt cho sức khỏe của bạn hay không? Lợi - hại ra sao?', 'anchao.jpg', NULL, NULL),
(NULL, '1', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'gaumuoi.jpg', NULL, NULL),
(NULL, '1', 'Giải đáp: Uống nước lá dứa có bị mờ mắt không?', 'ladua.jpg', NULL, NULL),
(NULL, '1', 'Giải đáp: Rong biển bị mốc có ăn được không?', 'rongbien.jpg', NULL, NULL),
(NULL, '1', 'Ăn dưa lưới có tác dụng gì? Cách ăn dưa lưới chuẩn ngon, bổ dưỡng', 'dualuoi.jpg', NULL, NULL),
(NULL, '2', 'Không ngủ trưa có tác hại gì – bạn đã biết chưa?', 'ngutrua.jpg', NULL, NULL),
(NULL, '2', 'Cúi xuống đột ngột bị đau lưng: Nguyên nhân và biện pháp điều trị thích hợp', 'cuixuong.jpg', NULL, NULL),
(NULL, '2', 'Nằm nệm bị đau lưng do đâu? Tư thế ngủ tốt nhất cho người bị đau lưng', 'namnem.jpg', NULL, NULL),
(NULL, '2', 'Giải pháp nào cho tình trạng bê đồ nặng bị đau lưng?', 'bedonang.jpg', NULL, NULL),
(NULL, '2', 'Giải đáp: Sinh mổ vùng kín có bị rộng không?', 'sinhmo.jpg', NULL, NULL),
(NULL, '3', 'Ăn cháo liên tục có tốt cho sức khỏe của bạn hay không? Lợi - hại ra sao?', 'a', NULL, NULL),
(NULL, '3', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '3', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '3', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '3', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '4', 'Ăn cháo liên tục có tốt cho sức khỏe của bạn hay không? Lợi - hại ra sao?', 'a', NULL, NULL),
(NULL, '4', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '4', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '4', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '5', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '5', 'Ăn cháo liên tục có tốt cho sức khỏe của bạn hay không? Lợi - hại ra sao?', 'a', NULL, NULL),
(NULL, '5', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '5', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '5', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL),
(NULL, '5', 'Gà ủ muối bao nhiêu calo? Cách ăn gà ủ muối ngon đúng chuẩn', 'a', NULL, NULL);

