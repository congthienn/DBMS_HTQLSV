-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 29, 2021 lúc 07:25 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dbms_htqlsv`
--
CREATE DATABASE IF NOT EXISTS `dbms_htqlsv` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `dbms_htqlsv`;

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `DiemHT_HK` (IN `msv` CHAR(8), IN `mahk` INT, IN `mank` INT)  BEGIN

   		SELECT khht.Ma_mon,Ten_mon,mh.Tin_chi,Diem_so,Diem_chu,DKHP FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon 
            JOIN hoc_ky hk ON hk.Ma_HK = khht.Ma_HK
            JOIN nien_khoa nk ON khht.Ma_NK = nk.Ma_NK
            WHERE MSSV = msv AND hk.Ma_HK = mahk AND nk.Ma_NK = mank AND DKHP ='1';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DiemTB_TL` (IN `msv` CHAR(8), IN `mahk` INT, IN `mank` INT)  BEGIN
		SELECT SUM(Tin_chi*Diem) / SUM(Tin_chi) tbtl FROM 
		(
		 SELECT Tin_chi,
		 CASE WHEN Diem_chu = 'A' THEN 4 
		 		WHEN Diem_chu = 'B+' THEN 3.5 
				WHEN Diem_chu = 'B' THEN 3 
				WHEN Diem_chu = 'C+' THEN 2.5 
				WHEN Diem_chu = 'C' THEN 2 
				WHEN Diem_chu = 'D+' 
				THEN 1.5 
				ELSE 1 
			END AS Diem FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon WHERE mssv= msv AND DKHP='1' AND (khht.Ma_HK + khht.Ma_NK) <= (mank+mahk) AND khht.Ma_NK <= mank
		) AS Diem;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Diem_TBTL_HK` (IN `msv` CHAR(8), IN `mahk` INT, IN `mank` INT)  BEGIN
		SELECT SUM(Tin_chi*Diem) / SUM(Tin_chi) tbtl FROM 
		(
		 SELECT Tin_chi,
		 CASE WHEN Diem_chu = 'A' THEN 4 
		 		WHEN Diem_chu = 'B+' THEN 3.5 
				WHEN Diem_chu = 'B' THEN 3 
				WHEN Diem_chu = 'C+' THEN 2.5 
				WHEN Diem_chu = 'C' THEN 2 
				WHEN Diem_chu = 'D+' THEN 1.5 
				WHEN Diem_chu = 'D' THEN 1
				ELSE 0 
			END AS Diem FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon WHERE mssv= msv AND DKHP = '1' AND khht.Ma_HK = mahk AND khht.Ma_NK= mank
		) AS Diem;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DKMH` (IN `msv` CHAR(8), IN `mahp` CHAR(5))  BEGIN
	UPDATE khht SET DKHP = 1 WHERE MSSV = msv AND Ma_mon = mahp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Huy_DKMH` (IN `msv` CHAR(8), IN `mahp` CHAR(5))  BEGIN
	UPDATE khht SET DKHP = 0 WHERE MSSV = msv AND Ma_mon = mahp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `KHHT` (IN `msv` CHAR(8))  BEGIN
        SELECT khht.Ma_mon,Ten_mon,mh.Tin_chi,Ten_HK,Ten_NK,hk.Ma_HK,nk.Ma_NK FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon 
        JOIN hoc_ky hk ON hk.Ma_HK = khht.Ma_HK
        JOIN nien_khoa nk ON khht.Ma_NK = nk.Ma_NK
        WHERE MSSV = msv ORDER BY nk.Ma_NK,hk.Ma_HK ASC;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Kiemtra_HP` (IN `msv` CHAR(8), IN `mahp` CHAR(5))  BEGIN
	SELECT * FROM khht WHERE MSSV = msv AND Ma_mon = mahp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Login_User` (IN `mssv` CHAR(8), IN `passwd` TEXT)  BEGIN 
        SELECT * FROM sinh_vien WHERE MSSV = mssv AND Password = passwd;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectHP_HK` (IN `msv` CHAR(8), IN `mahk` INT, IN `mank` INT)  BEGIN

   		SELECT khht.Ma_mon,Ten_mon,mh.Tin_chi,DKHP FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon 
            JOIN hoc_ky hk ON hk.Ma_HK = khht.Ma_HK
            JOIN nien_khoa nk ON khht.Ma_NK = nk.Ma_NK
            WHERE MSSV = msv AND hk.Ma_HK = mahk AND nk.Ma_NK = mank;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_HK` ()  BEGIN
	SELECT * FROM hoc_ky;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_Monhoc` ()  BEGIN
	SELECT * FROM mon_hoc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_NK_Dahoc` (IN `nam` INT, IN `length` INT)  BEGIN
       SELECT * FROM (
	SELECT Ma_NK,Ten_NK FROM nien_khoa WHERE CAST(SUBSTRING(Ten_NK,1,4) AS INT) >= nam LIMIT length
) AS NKhoa ORDER BY Ma_NK DESC;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Select_NK_DKHP` (IN `nam` INT)  BEGIN
       SELECT * FROM (
	SELECT Ma_NK,Ten_NK FROM nien_khoa WHERE CAST(SUBSTRING(Ten_NK,1,4) AS INT) >= nam LIMIT 5
) AS NKhoa ORDER BY Ma_NK ASC;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SoTC_DKHP` (IN `msv` CHAR(8), IN `mhk` INT, IN `mnk` INT)  BEGIN
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Student_Information` (IN `msv` CHAR(8))  BEGIN 
        SELECT * FROM sinh_vien sv JOIN lop ON sv.Ma_lop = lop.Ma_lop
        JOIN nganh ON lop.Ma_nganh = nganh.ID JOIN giang_vien gv ON lop.GVCV = gv.Ma_GV WHERE MSSV = msv;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ThemHP` (IN `msv` CHAR(8), IN `mhk` INT, IN `mnk` INT, IN `mhp` CHAR(5))  BEGIN
	INSERT INTO khht(MSSV,Ma_mon,Ma_HK,Ma_NK,DKHP) VALUES (msv,mhp,mhk,mnk,0);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Tinchi_MH` (IN `mhp` CHAR(5))  BEGIN
	SELECT Tin_chi FROM mon_hoc WHERE Ma_mon = mhp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TongTC_DKHP` (IN `msv` CHAR(8), IN `mhk` INT, IN `mnk` INT)  BEGIN
	SELECT SUM(Tin_chi) TongTC FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon WHERE MSSV = msv AND Ma_HK = mhk AND Ma_NK = mnk AND DKHP = '1';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TongTC_KHHT` (IN `msv` CHAR(8), IN `mahk` INT, IN `mank` INT)  BEGIN
	   SELECT SUM(Tin_chi) TongTC FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon
	   WHERE MSSV = msv;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TongTC_TL` (IN `msv` CHAR(8), IN `mahk` INT, IN `mank` INT)  BEGIN
	SELECT SUM(Tin_chi) TongTC FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon
	   WHERE MSSV = msv AND khht.DKHP='1' AND (khht.Ma_HK + khht.Ma_NK) <= (mank+mahk) AND khht.Ma_NK <= mank;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TongTC_TL_HK` (IN `msv` CHAR(8), IN `mahk` INT, IN `mank` INT)  BEGIN
	SELECT SUM(Tin_chi) TongTC FROM khht JOIN mon_hoc mh ON khht.Ma_mon = mh.Ma_mon
	   WHERE MSSV = msv AND khht.DKHP = '1' AND khht.Ma_HK = mahk AND khht.Ma_NK = mank;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Xoa_HP` (IN `msv` CHAR(8), IN `mahp` CHAR(5))  BEGIN
	DELETE FROM khht WHERE MSSV = msv AND Ma_mon = mahp;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giang_vien`
--

CREATE TABLE `giang_vien` (
  `Ma_GV` char(6) COLLATE utf8_unicode_ci NOT NULL,
  `Ten_GV` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SoDienthoai` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `giang_vien`
--

INSERT INTO `giang_vien` (`Ma_GV`, `Ten_GV`, `Email`, `SoDienthoai`) VALUES
('001944', 'Thái Minh Tuấn', 'minhtuan@ctu.edu.vn', '0938281133');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoc_ky`
--

CREATE TABLE `hoc_ky` (
  `Ma_HK` int(11) NOT NULL,
  `Ten_HK` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tin_chi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoc_ky`
--

INSERT INTO `hoc_ky` (`Ma_HK`, `Ten_HK`, `Tin_chi`) VALUES
(1, '1', 25),
(2, '2', 25);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khht`
--

CREATE TABLE `khht` (
  `MSSV` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `Ma_mon` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `Ma_HK` int(11) NOT NULL,
  `Ma_NK` int(11) NOT NULL,
  `Diem_so` float DEFAULT NULL,
  `Diem_chu` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DKHP` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khht`
--

INSERT INTO `khht` (`MSSV`, `Ma_mon`, `Ma_HK`, `Ma_NK`, `Diem_so`, `Diem_chu`, `DKHP`) VALUES
('B1809517', 'CT101', 1, 1, 8, 'B+', b'1'),
('B1809517', 'CT103', 1, 1, 8.5, 'B+', b'1'),
('B1809517', 'CT109', 1, 3, NULL, NULL, b'1'),
('B1809517', 'CT112', 2, 2, 7, 'B', b'1'),
('B1809517', 'CT172', 1, 1, 7.5, 'B', b'1'),
('B1809517', 'CT173', 2, 1, 9, 'A', b'1'),
('B1809517', 'CT174', 2, 1, 9, 'A', b'1'),
('B1809517', 'CT175', 1, 1, 7, 'B', b'1'),
('B1809517', 'CT176', 2, 1, 8, 'B', b'1'),
('B1809517', 'CT178', 1, 2, 8, 'B+', b'1'),
('B1809517', 'CT180', 2, 1, 8.5, 'B+', b'1'),
('B1809517', 'CT181', 1, 3, NULL, NULL, b'1'),
('B1809517', 'CT182', 2, 2, 8, 'B+', b'1'),
('B1809517', 'CT187', 2, 1, 7, 'B', b'1'),
('B1809517', 'CT202', 2, 2, 9, 'A', b'1'),
('B1809517', 'CT207', 2, 2, 8, 'B+', b'1'),
('B1809517', 'CT211', 2, 3, NULL, NULL, b'1'),
('B1809517', 'CT212', 1, 2, 6, 'C', b'1'),
('B1809517', 'CT221', 1, 2, 7.8, 'B', b'1'),
('B1809517', 'CT222', 2, 2, 8.5, 'B+', b'1'),
('B1809517', 'CT233', 2, 3, NULL, NULL, b'1'),
('B1809517', 'CT237', 1, 3, NULL, NULL, b'1'),
('B1809517', 'CT269', 1, 2, 7.5, 'B', b'1'),
('B1809517', 'CT271', 2, 3, NULL, NULL, b'1'),
('B1809517', 'CT311', 1, 1, 8, 'B+', b'1'),
('B1809517', 'CT332', 1, 2, 6.3, 'C', b'1'),
('B1809517', 'CT335', 2, 3, NULL, NULL, b'1'),
('B1809517', 'CT428', 1, 3, NULL, NULL, b'1'),
('B1809517', 'CT466', 2, 3, NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop`
--

CREATE TABLE `lop` (
  `Ma_lop` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Ten_lop` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ma_nganh` int(11) DEFAULT 0,
  `GVCV` char(6) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lop`
--

INSERT INTO `lop` (`Ma_lop`, `Ten_lop`, `Ma_nganh`, `GVCV`) VALUES
('DI18V7A1', 'Công nghệ thông tin A1', 1, '001944'),
('DI18V7A2', 'Công nghệ thông tin A2', 1, '001944'),
('DI18V7A3', 'Công nghệ thông tin A3', 1, '001944'),
('DI18V7A4', 'Công nghệ thông tin A4', 1, '001944');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mon_hoc`
--

CREATE TABLE `mon_hoc` (
  `Ma_mon` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `Ten_mon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tin_chi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mon_hoc`
--

INSERT INTO `mon_hoc` (`Ma_mon`, `Ten_mon`, `Tin_chi`) VALUES
('CT101', 'Lập trình căn bản A', 4),
('CT103', 'Cấu trúc dữ liệu', 4),
('CT109', 'Phân tích và thiết kế hệ thống thông tin', 3),
('CT112', 'Mạng máy tính', 3),
('CT171', 'Nhập môn công nghệ phần mềm', 3),
('CT172', 'Toán rời rạc', 4),
('CT173', 'Kiến trúc máy tính', 3),
('CT174', 'Phân tích và thiết kế thuật toán', 3),
('CT175', 'Lý thuyết đồ thị', 3),
('CT176', 'Lập trình hướng đối tượng', 3),
('CT178', 'Nguyên lý hệ điều hành', 3),
('CT180', 'Cơ sở dữ liệu', 3),
('CT181', 'Hệ thống thông tin doanh nghiệp', 3),
('CT182', 'Ngôn ngữ mô hình hóa', 3),
('CT187', 'Nền tảng công nghệ thông tin', 3),
('CT202', 'Nguyên lý máy học', 3),
('CT207', 'Phát triển mã nguồn mở', 3),
('CT211', 'An ninh mạng', 3),
('CT212', 'Quản trị mạng', 3),
('CT221', 'Lập trình mạng', 3),
('CT222', 'An toàn hệ thống', 3),
('CT233', 'Điện toán đám mây', 3),
('CT237', 'Nguyên lý hệ quản trị cơ sở dữ liệu', 3),
('CT269', 'Hệ quản trị CSDL Oracle', 2),
('CT271', 'Niên luận cơ sở - CNTT', 3),
('CT311', 'Phương pháp nghiên cứu khoa học', 2),
('CT332', 'Trí tuệ nhân tạo', 3),
('CT335', 'Thiết kế và cài đặt mạng', 3),
('CT428', 'Lập trình Web', 3),
('CT450', 'Thực tập thực tế', 2),
('CT466', 'Niên luận - CNTT', 3),
('CT593', 'Luận văn tốt nghiệp', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mon_tienquyet`
--

CREATE TABLE `mon_tienquyet` (
  `Ma_mon` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `Ma_mon_tienquyet` char(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mon_tienquyet`
--

INSERT INTO `mon_tienquyet` (`Ma_mon`, `Ma_mon_tienquyet`) VALUES
('CT103', 'CT101'),
('CT109', 'CT180'),
('CT112', 'CT178'),
('CT174', 'CT103'),
('CT175', 'CT103'),
('CT176', 'CT101'),
('CT178', 'CT173'),
('CT180', 'CT103'),
('CT207', 'CT101'),
('CT212', 'CT112'),
('CT221', 'CT112'),
('CT233', 'CT112'),
('CT335', 'CT112');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nganh`
--

CREATE TABLE `nganh` (
  `ID` int(11) NOT NULL,
  `Ten_nganh` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nganh`
--

INSERT INTO `nganh` (`ID`, `Ten_nganh`) VALUES
(1, 'Công nghệ thông tin'),
(2, 'Hệ thống thông tin'),
(3, 'Khoa học máy tính'),
(7, 'Kỹ thuật máy tính'),
(5, 'Kỹ thuật phần mềm'),
(4, 'Mạng máy tính và truyền thông'),
(6, 'Tin học ứng dụng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nien_khoa`
--

CREATE TABLE `nien_khoa` (
  `Ma_NK` int(11) NOT NULL,
  `Ten_NK` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nien_khoa`
--

INSERT INTO `nien_khoa` (`Ma_NK`, `Ten_NK`) VALUES
(8, '2017-2018'),
(7, '2018-2019'),
(1, '2019-2020'),
(2, '2020-2021'),
(3, '2021-2022'),
(4, '2022-2023'),
(5, '2023-2024'),
(6, '2024-2025');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sinh_vien`
--

CREATE TABLE `sinh_vien` (
  `MSSV` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `Ho_ten` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Gmail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ngay_sinh` date DEFAULT NULL,
  `Gioi_tinh` bit(1) DEFAULT NULL,
  `Dia_chi` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ma_lop` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Khoa_hoc` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Password` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Nam_BD` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sinh_vien`
--

INSERT INTO `sinh_vien` (`MSSV`, `Ho_ten`, `Gmail`, `Ngay_sinh`, `Gioi_tinh`, `Dia_chi`, `Ma_lop`, `Khoa_hoc`, `Password`, `Nam_BD`) VALUES
('B1809437', 'Bùi Châu Gia Bảo', 'baob1809437@student.ctu.edu.vn', '2000-01-30', b'1', 'Long Mỹ - Hậu Giang', 'DI18V7A4', '44', 'Bao1', 2019),
('B1809517', 'Nguyễn Công Thiện', 'thienb1809517@student.ctu.edu.vn', '2000-01-16', b'1', '755/1 - Hòa An - Mong Thọ - Châu Thành - Kiên Giang', 'DI18V7A4', '44', 'CongThien372015231', 2019);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `giang_vien`
--
ALTER TABLE `giang_vien`
  ADD PRIMARY KEY (`Ma_GV`);

--
-- Chỉ mục cho bảng `hoc_ky`
--
ALTER TABLE `hoc_ky`
  ADD PRIMARY KEY (`Ma_HK`),
  ADD UNIQUE KEY `Ten_HK` (`Ten_HK`);

--
-- Chỉ mục cho bảng `khht`
--
ALTER TABLE `khht`
  ADD PRIMARY KEY (`MSSV`,`Ma_mon`,`Ma_HK`,`Ma_NK`),
  ADD UNIQUE KEY `MSSV_Ma_mon` (`MSSV`,`Ma_mon`),
  ADD KEY `FK__nien_khoa` (`Ma_NK`),
  ADD KEY `FK_khht_hoc_ky` (`Ma_HK`),
  ADD KEY `Ma_mon` (`Ma_mon`);

--
-- Chỉ mục cho bảng `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`Ma_lop`),
  ADD UNIQUE KEY `Ten_lop` (`Ten_lop`),
  ADD KEY `FK__khoa` (`Ma_nganh`) USING BTREE,
  ADD KEY `FK_lop_giang_vien` (`GVCV`);

--
-- Chỉ mục cho bảng `mon_hoc`
--
ALTER TABLE `mon_hoc`
  ADD PRIMARY KEY (`Ma_mon`),
  ADD UNIQUE KEY `Ten_mon` (`Ten_mon`);

--
-- Chỉ mục cho bảng `mon_tienquyet`
--
ALTER TABLE `mon_tienquyet`
  ADD PRIMARY KEY (`Ma_mon`,`Ma_mon_tienquyet`),
  ADD KEY `FK_mon_tienquyet_mon_hoc_2` (`Ma_mon_tienquyet`);

--
-- Chỉ mục cho bảng `nganh`
--
ALTER TABLE `nganh`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Ten_nganh` (`Ten_nganh`);

--
-- Chỉ mục cho bảng `nien_khoa`
--
ALTER TABLE `nien_khoa`
  ADD PRIMARY KEY (`Ma_NK`),
  ADD UNIQUE KEY `Ten_NK` (`Ten_NK`);

--
-- Chỉ mục cho bảng `sinh_vien`
--
ALTER TABLE `sinh_vien`
  ADD PRIMARY KEY (`MSSV`),
  ADD UNIQUE KEY `Gmail` (`Gmail`) USING HASH,
  ADD UNIQUE KEY `Password` (`Password`) USING HASH,
  ADD KEY `FK_sinh_vien_lop` (`Ma_lop`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `hoc_ky`
--
ALTER TABLE `hoc_ky`
  MODIFY `Ma_HK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `nganh`
--
ALTER TABLE `nganh`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `nien_khoa`
--
ALTER TABLE `nien_khoa`
  MODIFY `Ma_NK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `khht`
--
ALTER TABLE `khht`
  ADD CONSTRAINT `FK__mon_hoc` FOREIGN KEY (`Ma_mon`) REFERENCES `mon_hoc` (`Ma_mon`),
  ADD CONSTRAINT `FK__nien_khoa` FOREIGN KEY (`Ma_NK`) REFERENCES `nien_khoa` (`Ma_NK`),
  ADD CONSTRAINT `FK__sinh_vien` FOREIGN KEY (`MSSV`) REFERENCES `sinh_vien` (`MSSV`),
  ADD CONSTRAINT `FK_khht_hoc_ky` FOREIGN KEY (`Ma_HK`) REFERENCES `hoc_ky` (`Ma_HK`);

--
-- Các ràng buộc cho bảng `lop`
--
ALTER TABLE `lop`
  ADD CONSTRAINT `FK_lop_giang_vien` FOREIGN KEY (`GVCV`) REFERENCES `giang_vien` (`Ma_GV`),
  ADD CONSTRAINT `FK_lop_nganh` FOREIGN KEY (`Ma_nganh`) REFERENCES `nganh` (`ID`);

--
-- Các ràng buộc cho bảng `mon_tienquyet`
--
ALTER TABLE `mon_tienquyet`
  ADD CONSTRAINT `FK_mon_tienquyet_mon_hoc` FOREIGN KEY (`Ma_mon`) REFERENCES `mon_hoc` (`Ma_mon`),
  ADD CONSTRAINT `FK_mon_tienquyet_mon_hoc_2` FOREIGN KEY (`Ma_mon_tienquyet`) REFERENCES `mon_hoc` (`Ma_mon`);

--
-- Các ràng buộc cho bảng `sinh_vien`
--
ALTER TABLE `sinh_vien`
  ADD CONSTRAINT `FK_sinh_vien_lop` FOREIGN KEY (`Ma_lop`) REFERENCES `lop` (`Ma_lop`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
