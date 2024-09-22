
-- a  Liệt kê các bài viết về các bài hát thuộc thể loại Nhạc trữ tình 
	SELECT baiviet.tieude,baiviet.ten_bhat
    from baiviet
    join theloai ON theloai.ma_tloai = baiviet.ma_tloai
    where theloai.ten_tloai = "Nhạc trữ tình";
    
-- b Liệt kê các bài viết của tác giả “Nhacvietplus” (2 đ)
	select baiviet.ten_bhat
    from baiviet
    join tacgia on tacgia.ma_tgia = baiviet.ma_tgia
    where tacgia.ten_tgia = "Nhacvietplus";
    
-- c Liệt kê các thể loại nhạc chưa có bài viết cảm nhận nào.
	select DISTINCT theloai.ten_tloai, theloai.ma_tloai
    from theloai
    left join baiviet on baiviet.ma_tloai = theloai.ma_tloai
    where baiviet.ma_tloai is null;
    
-- d Liệt kê các bài viết với các thông tin sau: mã bài viết, tên bài viết, tên bài hát, tên tác giả, tên 
-- thể loại, ngày viết
	SELECT baiviet.ma_bviet,baiviet.tieude ,baiviet.ten_bhat,tacgia.ten_tgia,theloai.ten_tloai,baiviet.ngayviet
    from baiviet  
    join theloai  on baiviet.ma_tloai=theloai.ma_tloai
    JOIN tacgia  on baiviet.ma_tgia= tacgia.ma_tgia;
    
    -- e Tìm thể loại có số bài viết nhiều nhất
    SELECT ma_bviet,tieude, COUNT(theloai.ma_tloai) as tlcount
    from baiviet
    left join theloai on theloai.ma_tloai=baiviet.ma_tloai
    group by baiviet.ma_bviet,baiviet.tieude
    ORDER by tlcount DESC
    limit 1;
    
    -- f Liệt kê 2 tác giả có số bài viết nhiều nhất
    SELECT tacgia.ten_tgia,count(baiviet.ma_bviet) as baivietcount
    from tacgia
    left join baiviet on baiviet.ma_tgia = tacgia.ma_tgia
    group by tacgia.ma_tgia,tacgia.ten_tgia
    order by baivietcount DESC
    limit 2;
    
 	-- g Liệt kê các bài viết về các bài hát có tựa bài hát chứa 1 trong các từ “yêu”, “thương”, “anh”, “em”
    SELECT *
    FROM baiviet
    WHERE tieude LIKE '%yêu%'
       OR tieude LIKE '%thương%'
       OR tieude LIKE '%anh%'
       OR tieude LIKE '%em%';
   
   -- h Liệt kê các bài viết về các bài hát có tiêu đề bài viết hoặc tựa bài hát chứa 1 trong các từ “yêu”, “thương”, “anh”, “em”
		SELECT bv.ma_bviet,bv.tieude,bv.tomtat,bv.ngayviet,tg.ten_tgia,tl.ten_tloai
        FROM baiviet bv
        Left join tacgia tg on bv.ma_tgia=tg.ma_tgia
        left join theloai tl on bv.ma_tloai=tl.ma_tloai
        WHERE (bv.tieude REGEXP 'yêu|thương|anh|em' OR
              bv.ten_bhat REGEXP 'yêu|thương|anh|em');
        
   -- i Tạo 1 view có tên vw_Music để hiển thị thông tin về Danh sách các bài viết kèm theo Tên thể loại và tên tác giả
   		
SELECT 
    bv.ma_bviet,
    bv.tieude,
    bv.tomtat,
    bv.ngayviet,
    tg.ten_tgia AS ten_tac_gia,
    tl.ten_tloai AS ten_the_loai
FROM 
    baiviet bv
JOIN 
    tacgia tg ON bv.ma_tgia = tg.ma_tgia
JOIN 
    theloai tl ON bv.ma_tloai = tl.ma_tloai;
SELECT * FROM vw_Music;

   -- j Tạo 1 thủ tục có tên sp_DSBaiViet với tham số truyền vào là Tên thể loại và trả về danh sách Bài viết của thể loại đó. Nếu thể loại không tồn tại thì hiển thị thông báo lỗi.
   
   -- k Thêm mới cột SLBaiViet vào trong bảng theloai. Tạo 1 trigger có tên tg_CapNhatTheLoai để khi thêm/sửa/xóa bài viết thì số lượng bài viết trong bảng theloai được cập nhật theo

   --l. Bổ sung thêm bảng Users để lưu thông tin Tài khoản đăng nhập và sử dụng cho chức năng Đăng nhập/Quản trị trang web. (5 đ)
