$(document).ready(function() {
	$('#dataTables-example').DataTable({
		responsive: true
	});
});

$("div.alert").delay(3000).slideUp();

function xacNhanXoa(msg){
	if(window.confirm(msg)){
		return true;
	}
	return false;
};

$(document).ready(function(){
	$("#addImage").click(function(){
		$("#insert").append('<div class="form-group"><input type="file" name="fEditDetail[]"></div>');

	});
});

// Tại sao sửa file myscript load lại trang không nhận. phải xóa cache mới chạy được @@
// Làm việc với Ajax cần sửa lỗi: type:GET ~ bên route:GET , Use Illuminate\Http\Request(controller)->use Request;
$(document).ready(function(){
	$("a#del_img_demo").on('click',function() {
		var url="http://localhost/Laravel/admin/product/delimg/";
		var _token = $("form[name='frmEditProduct']").find("input[name='_token']").val();//Tìm trong form có name='frmEditProduct'. làm việc trong form cần token để bảo mật. Bắt buộc của ajax trong laravel 
		var idHinh = $(this).parent().find("img").attr("idHinh");//Thẻ img là parent của thẻ a. idHinh=24,25...
		var img = $(this).parent().find("img").attr("src"); //lấy ra url của image
		var rid = $(this).parent().find("img").attr("id");  //rid = key trong mảng
		// alert(idHinh);
		// alert(img);
	   //alert(rid);
		$.ajax({             //Dùng ajax xóa detail_image
			url: url + idHinh,
			type: 'GET',
			cache: false,
			data: {"_token":_token,"idHinh":idHinh,"urlHinh":img},
			success: function (data){
				if(data == "Delete"){    //Data là giá trị trả về trog function getDelImg
					$("#"+rid).remove(); // rid = $key trong mảng. 0,1,2,3....
				} else{
					//alert("Error! Please Contact Admin");
				}
			}
		});
	});
});