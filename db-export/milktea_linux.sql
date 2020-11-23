-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 09, 2020 lúc 05:30 AM
-- Phiên bản máy phục vụ: 10.4.13-MariaDB
-- Phiên bản PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `milktea`
--


-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `iduser`) VALUES
(5, 5),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'LATTE SERIES'),
(2, 'THỨC UỐNG ĐẶC BIỆT'),
(3, 'TRÀ SỮA'),
(4, 'TRÀ NGUYÊN CHẤT'),
(5, 'THỨC UỐNG SÁNG TẠO'),
(6, 'THỨC UỐNG ĐÁ XAY');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idpost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`id`, `content`, `createdAt`, `iduser`, `idpost`) VALUES
(48, 'How you like that?', '2020-07-08 21:00:20', 7, 15),
(49, 'hello', '2020-07-08 22:14:35', 7, 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `facebook` text DEFAULT NULL,
  `instagram` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `contact`
--

INSERT INTO `contact` (`id`, `address`, `phone`, `email`, `facebook`, `instagram`) VALUES
(1, 'KTX', '0338616558', 'minh.nguyennhat@gmail.com', 'https://facebook.com/nhminhLT', 'https://instagram.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `phone` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `address`, `status`, `iduser`, `created_at`, `phone`) VALUES
(4, 'KTX', 1, 5, NULL, NULL),
(6, 'KTX', 1, 7, '2020-07-08 17:03:19', NULL),
(7, 'KTX khu A, Thủ Đức, Tp. Hồ Chí Minh', 1, 7, '2020-07-09 09:46:34', '0967740752'),
(8, 'KTX khu A, Thủ Đức, Tp. Hồ Chí Minh', 1, 7, '2020-07-09 09:47:25', '0967740752'),
(9, 'Khu phố Phú Thứ, Thị trấn Phú Thứ', 3, 8, '2020-07-09 09:55:12', '0967740752'),
(10, 'Khu phố Phú Thứ, Thị trấn Phú Thứ', 4, 8, '2020-07-09 10:06:55', '0967740752'),
(11, 'Khu phố Phú Thứ, Thị trấn Phú Thứ', 3, 8, '2020-07-09 10:18:36', '0967740752');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `image` text DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `title` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `post`
--

INSERT INTO `post` (`id`, `content`, `createdAt`, `image`, `iduser`, `title`) VALUES
(15, 'Cất em trong lòng tim của anh', '2020-07-08 20:58:54', 'http://localhost/milktea/img/posts/girl_xinh_11711843877255f05d11e1639d3.65535135.jpg', 7, 'Yêu như ngày yêu cuối'),
(16, 'Content', '2020-07-08 21:00:44', 'http://localhost/milktea/img/posts/girl_xinh_05315091709085f05d18ce5cd64.90887197.jpg', 7, 'Title one'),
(17, 'Chắc gì nữa mà chắc, sáng thì nhớ đêm trằng tương tư thì không phải yêu là gì?', '2020-07-09 00:27:01', 'http://localhost/milktea/img/posts/girl_xinh_14313164439515f0601e5891e93.60805807.jpg', 7, 'Có chắc yêu là đây');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `idcategory` int(11) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `idcategory`, `name`, `image`, `description`) VALUES
(2, 1, 'Okinawa Latte', 'https://gongcha.com.vn/wp-content/uploads/2018/06/Hinh-Web-OKINAWA-LATTE.png', '   Test Description with space'),
(3, 2, 'Trà Bí Đao Kem Sữa', 'https://gongcha.com.vn/wp-content/uploads/2018/02/Tr%C3%A0-B%C3%AD-%C4%90ao-Milkfoam-2.png', 'Contrary to popular belief, Lorem Ipsum is not simply random text;There are many variations of passages of Lorem Ipsum available;Latin words, combined with a handful of model sentence  '),
(4, 2, 'Trà Oolong Kem Sữa', 'https://gongcha.com.vn/wp-content/uploads/2018/02/Tr%C3%A0-Oolong-Milkfoam-3.png', 'There are many variations of passages of Lorem Ipsum available;Latin words, combined with a handful of model sentence  '),
(5, 2, 'Trà Alisan Kem Sữa', 'https://gongcha.com.vn/wp-content/uploads/2018/02/Tr%C3%A0-Alisan-Milkfoam-2.png', ' Free from repetition, injected humour, or non-characteristic words etc.; Latin words, combined with a handful of model sentence  ; Sections 1.10.32 and 1.10.33'),
(6, 3, 'Trà sữa Oolong 3J', 'https://gongcha.com.vn/wp-content/uploads/2018/02/Tr%C3%A0-s%E1%BB%AFa-Oolong-3J-2.png', ' Free from repetition, injected humour, or non-characteristic words etc.; Latin words, combined with a handful of model sentence  ; Sections 1.10.32 and 1.10.33;  consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam'),
(7, 3, 'Trà Sữa Chocolate', 'https://gongcha.com.vn/wp-content/uploads/2018/02/Tr%C3%A0-s%E1%BB%AFa-Chocolate-2.png', ' Free from repetition, injected humour, or non-characteristic words etc.; Latin words, combined with a handful of model sentence  ; Sections 1.10.32 and 1.10.33;  consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam'),
(8, 4, 'Trà Bí Đao Alisan', 'https://gongcha.com.vn/wp-content/uploads/2018/02/Tr%C3%A0-B%C3%AD-%C4%90ao-Milkfoam-2.png', 'Free from repetition, injected humour, or non-characteristic words etc.; Latin words, combined with a handful of model sentence'),
(10, 3, 'Trà sữa Long Cha PY', 'https://gongcha.com.vn/wp-content/uploads/2019/06/Mango-Milktea.png', 'Ngon như người yêu cũ của bạn'),
(11, 3, 'Trà Sữa Khoai Môn', 'https://gongcha.com.vn/wp-content/uploads/2018/01/Tr%C3%A0-s%E1%BB%AFa-Khoai-m%C3%B4n-2.png', 'trà sữa và khoai môn'),
(12, 6, 'Matcha Đá Xay', 'https://gongcha.com.vn/wp-content/uploads/2018/02/Matcha-%C4%91%C3%A1-xay-2.png', 'Matcha xay cùng với sữa, kết hợp với lớp Kem (Whipping Cream) phía trên.'),
(13, 5, 'Mango Matcha Latte', 'https://gongcha.com.vn/wp-content/uploads/2018/06/Mango-Matcha-Latte.png', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productincart`
--

CREATE TABLE `productincart` (
  `idcart` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `idsize` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productinorders`
--

CREATE TABLE `productinorders` (
  `idorder` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `idsize` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `productinorders`
--

INSERT INTO `productinorders` (`idorder`, `idproduct`, `quantity`, `idsize`) VALUES
(4, 2, 1, 1),
(6, 2, 1, 1),
(7, 4, 2, 2),
(8, 4, 1, 1),
(8, 6, 1, 2),
(8, 10, 2, 1),
(9, 4, 1, 2),
(9, 8, 1, 1),
(10, 12, 1, 1),
(10, 13, 1, 2),
(11, 11, 1, 2),
(11, 12, 1, 1),
(11, 13, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `response`
--

CREATE TABLE `response` (
  `id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idcomment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `numberstar` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idproduct` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `review`
--

INSERT INTO `review` (`id`, `content`, `createdAt`, `numberstar`, `iduser`, `idproduct`) VALUES
(6, 'Tôi không thích sản phẩm này', '2020-07-09 02:44:07', 1, 8, 4),
(8, 'Lần thứ 2 tôi uống', '2020-07-09 02:45:16', 4, 8, 10),
(11, '', '2020-07-09 03:41:35', 4, 8, 2),
(12, 'Tuyệt vời', '2020-07-09 09:45:58', 5, 7, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `size` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `size`
--

INSERT INTO `size` (`id`, `size`) VALUES
(1, 'M'),
(2, 'L');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizeofproduct`
--

CREATE TABLE `sizeofproduct` (
  `idproduct` int(11) NOT NULL,
  `idsize` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `sizeofproduct`
--

INSERT INTO `sizeofproduct` (`idproduct`, `idsize`, `price`, `quantity`) VALUES
(2, 1, 55000, 6),
(2, 2, 60000, 10),
(3, 1, 45000, 9),
(4, 1, 48000, 9),
(4, 2, 58000, 9),
(5, 1, 52000, 15),
(5, 2, 59000, 5),
(6, 2, 57000, 0),
(7, 1, 52000, 12),
(7, 2, 60000, 12),
(8, 1, 54000, 11),
(8, 2, 60000, 3),
(10, 1, 30000, 10),
(11, 1, 50000, 4),
(11, 2, 55000, 5),
(12, 1, 63000, 3),
(13, 2, 57000, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `isAdmin` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `phone` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `birthday`, `avatar`, `isAdmin`, `address`, `gender`, `phone`) VALUES
(3, 'admin', 'admin@gmail.com', '$2y$10$WkgI3WzcCaBi/Zsed/u1FOO0jZ64SwBv9vjasPqR0gnU1132OV3ZO', NULL, 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png', 1, NULL, NULL, NULL),
(5, 'hello', 'hellominh@gmail.com', '$2y$10$CKoYhZxQmvHA4Z/mbe7XYe/4WU7wrLgDoEnjpHa54vSMM6sNbfqju', '0000-00-00', 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png', NULL, 'KTX', 0, NULL),
(7, 'Nguyen Nhat Minh', 'minh@gmail.com', '$2y$10$Wl2VDMSjC.gxwPENUnyMquJVMhf830qbQFcKbahqBkE9HnekQcvKe', '0000-00-00', 'http://localhost/milktea/img/avatar/girl_xinh_158578884035f059aa1a6f1d0.66852091.jpg', NULL, 'KTX', 1, '0338616558'),
(8, 'Nguyễn Lê Hoàng Hiệu', 'hoanghieupro1999@gmail.com', '$2y$10$9m3aDLwE5M8.mt7hcNwXiudqEUSRkgF2AnsRAzzj5AEFIyjOABHxa', '1999-04-17', 'http://localhost/milktea/img/avatar/avatar11562506735f06885dc51782.00454687.jpg', NULL, 'Khu phố Phú Thứ, Thị trấn Phú Thứ', 1, '0967740752'),
(9, 'Phạm Minh Hiển', 'phamminhhien1999py@gmail.com', '$2y$10$vrxNbGNmIZ7a/NicsTKgru/GbtSV5mQCPg65Kx5u0IPQCpndAhlTG', NULL, 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png', NULL, NULL, NULL, NULL),
(10, 'Phạm Tấn Đại', 'daipham2506@gmail.com', '$2y$10$5vaCKC5T8YkfYBlWa22n8e2jq8SSyMoWjWsx6T0ET7W5M9760FTW2', NULL, 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png', NULL, NULL, NULL, NULL),
(11, 'Nhật Minh Offical', 'nhatminhpropy@gmail.com', '$2y$10$XNAcIgtmlnYEJyrdgoZEgeAmfserg506z.IS0LUeMwaZmt7BjTClO', NULL, 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png', NULL, NULL, NULL, NULL),
(12, 'Nguyễn Văn Toàn', 'hoanghieu.hcmut.1999@gmail.com', '$2y$10$4qEfRnI/peULiu.hKvdI7OnNloLl47SpWkLqvA3Jfq4.gU1Q9xfFC', NULL, 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png', NULL, NULL, NULL, NULL),
(13, 'Võ Ngọc Huyền My', 'huyenmy2000@gmail.com', '$2y$10$lk2gdwFHhV30ZqQzI4OJyeYpuxCX3mgDXFBtv4FXLYeJshvKPFa7S', NULL, 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png', NULL, NULL, NULL, NULL),
(14, 'Đặng Huỳnh Tiểu Vy', 'tieuvy2002@gmail.com', '$2y$10$vC.v2H6gBehWivv8vDapj.v31DBG6g0bolHM7Y6TKey3Hf4uZDyye', NULL, 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png', NULL, NULL, NULL, NULL);



--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idpost` (`idpost`);

--
-- Chỉ mục cho bảng `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcategory` (`idcategory`);

--
-- Chỉ mục cho bảng `productincart`
--
ALTER TABLE `productincart`
  ADD PRIMARY KEY (`idcart`,`idproduct`),
  ADD KEY `idsize` (`idsize`),
  ADD KEY `idproduct` (`idproduct`);

--
-- Chỉ mục cho bảng `productinorders`
--
ALTER TABLE `productinorders`
  ADD PRIMARY KEY (`idorder`,`idproduct`),
  ADD KEY `idsize` (`idsize`),
  ADD KEY `idproduct` (`idproduct`);

--
-- Chỉ mục cho bảng `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idcomment` (`idcomment`);

--
-- Chỉ mục cho bảng `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idproduct` (`idproduct`);

--
-- Chỉ mục cho bảng `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sizeofproduct`
--
ALTER TABLE `sizeofproduct`
  ADD PRIMARY KEY (`idproduct`,`idsize`),
  ADD KEY `idsize` (`idsize`);

--
-- Chỉ mục cho bảng `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `response`
--
ALTER TABLE `response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`idpost`) REFERENCES `post` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`idcategory`) REFERENCES `category` (`id`);

--
-- Các ràng buộc cho bảng `productincart`
--
ALTER TABLE `productincart`
  ADD CONSTRAINT `productincart_ibfk_2` FOREIGN KEY (`idcart`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `productincart_ibfk_3` FOREIGN KEY (`idproduct`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `productinorders`
--
ALTER TABLE `productinorders`
  ADD CONSTRAINT `productinorders_ibfk_2` FOREIGN KEY (`idorder`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `productinorders_ibfk_3` FOREIGN KEY (`idproduct`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `response_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `response_ibfk_2` FOREIGN KEY (`idcomment`) REFERENCES `comment` (`id`);

--
-- Các ràng buộc cho bảng `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `sizeofproduct`
--
ALTER TABLE `sizeofproduct`
  ADD CONSTRAINT `sizeofproduct_ibfk_1` FOREIGN KEY (`idsize`) REFERENCES `size` (`id`),
  ADD CONSTRAINT `sizeofproduct_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CREATE_ORDER` (IN `iduser` INT(11), IN `addressuser` TEXT, IN `input_phone` TEXT)  BEGIN
        -- declare
        DECLARE user_address TEXT; DECLARE orderid INT(11); DECLARE productid INT(11); DECLARE productidsize INT(11); DECLARE productquantity INT(11); DECLARE time_created DATETIME; DECLARE no_more_products INT DEFAULT 0; DECLARE cur_product CURSOR FOR
    SELECT
        productincart.idproduct,
        productincart.idsize,
        productincart.quantity
    FROM
        productincart,
        cart
    WHERE
        productincart.idcart = cart.id AND cart.iduser = iduser; DECLARE CONTINUE
    HANDLER FOR NOT FOUND
SET
    no_more_products = 1;
    -- create order
SELECT
    CURRENT_TIMESTAMP
INTO time_created;
SELECT
    address
INTO user_address
FROM
    users
WHERE
    id = iduser;
INSERT INTO orders(
    address,
STATUS
    ,
    iduser,
    created_at,
    phone
)
VALUE
    (
        addressuser,
        1,
        iduser,
        time_created,
        input_phone
    );
    -- add productinorders
SELECT
    LAST_INSERT_ID()
INTO orderid; OPEN cur_product; FETCH cur_product
INTO productid, productidsize, productquantity; REPEAT
INSERT INTO productinorders
VALUE
    (
        orderid,
        productid,
        productquantity,
        productidsize
    );
UPDATE
    sizeofproduct
SET
    quantity = quantity - productquantity
WHERE
    idsize = productidsize AND idproduct = productid; FETCH cur_product
INTO productid, productidsize, productquantity; UNTIL no_more_products = 1
    END REPEAT; CLOSE cur_product;
DELETE
    productincart
FROM
    productincart,
    cart
WHERE
    productincart.idcart = cart.id AND cart.iduser = iduser;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCartByIdUser` (IN `id_user` INT)  NO SQL
BEGIN
	DECLARE finished_cart INTEGER DEFAULT 0;
	DECLARE id_cart INTEGER DEFAULT 0;
    
    -- deleteCart
    DEClARE curCart
		CURSOR FOR 
			SELECT id FROM cart WHERE cart.iduser = id_user;
     DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished_cart = 1;
     OPEN curCart;
     
     deleteCart: LOOP
		FETCH curCart INTO id_cart;
        IF finished_cart = 1 THEN 
			LEAVE deleteCart;
		END IF;
        
		DELETE FROM productincart WHERE productincart.idcart = id_cart;
	
	END LOOP deleteCart;
    CLOSE curCart;
    DELETE FROM cart WHERE cart.iduser = id_user;
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteComment` (IN `id_comment` INT)  NO SQL
BEGIN
DELETE FROM response WHERE response.idcomment=id_comment;
DELETE FROM comment WHERE comment.id=id_comment;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCommentByUserId` (IN `id_user` INT)  NO SQL
BEGIN
	-- DECLARE id_comment integer DEFAULT 0;
    -- SELECT comment.id into id_comment WHERE comment.iduser = id_user;
    DECLARE finished INTEGER DEFAULT 0;
	DECLARE id_comment INTEGER DEFAULT 0;
    
    DEClARE curComment
		CURSOR FOR 
			SELECT id FROM comment WHERE comment.iduser=id_user;
     DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;
     OPEN curComment;
     
     deleteComment: LOOP
		FETCH curComment INTO id_comment;
        IF finished = 1 THEN 
			LEAVE deleteComment;
		END IF;
        
		DELETE FROM response WHERE response.idcomment=id_comment;
	
	END LOOP deleteComment;
    CLOSE curComment;
    DELETE FROM comment WHERE comment.iduser = id_user;
    DELETE FROM response WHERE response.iduser = id_user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteOrderByUserId` (IN `id_user` INT)  NO SQL
BEGIN
	-- declare for delete order
    DECLARE finished_order INTEGER DEFAULT 0;
	DECLARE id_order INTEGER DEFAULT 0;
    
    -- deleteOrder
    DEClARE curOrder
		CURSOR FOR 
			SELECT id FROM orders WHERE orders.iduser = id_user;
     DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished_order = 1;
     OPEN curOrder;
     
     deleteOrder: LOOP
		FETCH curOrder INTO id_order;
        IF finished_order = 1 THEN 
			LEAVE deleteOrder;
		END IF;
        
		DELETE FROM productinorders WHERE productinorders.idorder = id_order;
	
	END LOOP deleteOrder;
    CLOSE curOrder;
    DELETE FROM orders WHERE orders.iduser = id_user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePost` (IN `id_post` INT)  NO SQL
BEGIN
	DECLARE finished INTEGER DEFAULT 0;
	DECLARE id_comment INTEGER DEFAULT 0;
    
    DEClARE curComment
		CURSOR FOR 
			SELECT id FROM comment WHERE comment.idpost=id_post;
     DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;
     OPEN curComment;
     
     deleteComment: LOOP
		FETCH curComment INTO id_comment;
        IF finished = 1 THEN 
			LEAVE deleteComment;
		END IF;
        
		DELETE FROM response WHERE response.idcomment=id_comment;
	
	END LOOP deleteComment;
    CLOSE curComment;
    DELETE FROM comment WHERE comment.idpost = id_post;
    DELETE FROM post WHERE post.id = id_post;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePostByUserId` (IN `id_user` INT)  NO SQL
BEGIN
	DECLARE id_post integer DEFAULT 0;
    SELECT post.id INTO id_post FROM post WHERE post.iduser = id_user;
    CALL deletePost(id_post);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteProduct` (IN `id_product` INT)  NO SQL
BEGIN
DELETE FROM review WHERE review.idproduct = id_product;
DELETE FROM productinorders WHERE productinorders.idproduct = id_product;
DELETE FROM productincart WHERE productincart.idproduct = id_product;
DELETE FROM sizeofproduct WHERE sizeofproduct.idproduct = id_product;
DELETE FROM product WHERE product.id = id_product;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser` (IN `id_user` INT)  NO SQL
BEGIN
    DELETE FROM review WHERE review.iduser = id_user;
    
    CALL deleteCommentByUserId(id_user);
    
    DELETE FROM post WHERE post.iduser = id_user;
    
    CALL deleteCartByIdUser(id_user);
    
    CALL deleteOrderByUserId(id_user);
    
    
    
    DELETE FROM users WHERE users.id = id_user;
END$$

--
-- Các hàm
--
CREATE DEFINER=`root`@`localhost` FUNCTION `checkquantity` (`id` INT(11)) RETURNS INT(11) BEGIN
	DECLARE productid int(11);
    DECLARE productidsize int(11);
    DECLARE productquantity int(11);
    DECLARE productremain int(11);
    DECLARE no_more INT DEFAULT 0;
    DECLARE cursorProduct CURSOR FOR
    Select productincart.idproduct, productincart.idsize, productincart.quantity FROM productincart,cart WHERE productincart.idcart = cart.id AND cart.iduser = id;
    DECLARE  CONTINUE HANDLER FOR NOT FOUND
	SET  no_more = 1;
    OPEN cursorProduct;
    FETCH cursorProduct INTO productid, productidsize, productquantity;
    REPEAT
        	select quantity into productremain from sizeofproduct where idsize = productidsize and idproduct = productid;
            IF productremain < productquantity THEN
            	CLOSE cursorProduct;
                return productid;
            END IF;
            FETCH cursorProduct INTO productid, productidsize, productquantity;
      UNTIL no_more = 1
      END REPEAT;
      CLOSE cursorProduct;
      return 0;  
END$$

CREATE TRIGGER `AUTO_CREATE_CART` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	DECLARE userId int(11);
    SET userId = new.id;
    INSERT INTO cart value(userId,userId);
END
$$

DELIMITER ;

