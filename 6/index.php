<html>
<head>
<meta charset="utf-8">
<title></title>
<style>
	*{
		margin: 0;
		padding: 0;
	}
	html,body{
		margin: 1%;
	}
	h1{
		margin-bottom: 30px;
	}	
	input, textarea{
		border: 1px solid #ccc;
	}
	span{
		width: 200px;
	}
	.form__name, .form__age, .form__email,
	.form__sex, .form__syumi, .form__free{
		margin: 10px 0;
		width: 400px;
		padding-top: 15px;
		position: relative;
	}
	.form__free span{
		vertical-align: top;
	}
	.form__submit{
		color: #1A71FD;
		background-color: #fff;

		padding: 5px 15px;
		cursor: pointer;
		border: none;
		border: 1px solid #1A71FD;
		font-size: 1.1rem;
		font-weight: bold;
		margin-top: 30px;
	}
	.form__submit:hover{
		background-color: #1A71FD;
		color: #fff;
	}

	.errorMsg{
		position: absolute;
		color: #f00;
		top: 0;
		font-size: .6rem;
	}


</style>
</head>
<body>
<H1>すごいアンケート</H1>
<form action="check_name.php" method="post" id="myForm">
	<div class="form__name">
		<span>名前 : </span><input type="text" name="name" />
	</div>
	<div class="form__age">
		<span>年齢 : </span><input type="text" name="age" />
	</div>
	<div class="form__email">
		<span>e-mail : </span><input type="text" name="email" />
	</div>
	<div class="form__sex">
		<span>性別 :</span> 
		<input type="radio" name="sex" id="male" value="1" checked/>
		<label for="male">男</label>
		<input type="radio" name="sex" id="female" value="2" />
		<label for="female">女</label>
	</div>
	<div class="form__syumi">
		<span>趣味 : </span>
		<input type="checkbox" name="syumi[]" value="1" /> スポーツ
		<input type="checkbox" name="syumi[]" value="2" /> 映画鑑賞
		<input type="checkbox" name="syumi[]" value="3" /> 読書
		<input type="checkbox" name="syumi[]" value="4" /> 料理
	</div>
	<div class="form__free">
		<span>その他 : </span><textarea name="free" rows="4" cols="40"></textarea>
	</div>
	<input type="submit" class="form__submit" value="確認" /> 
</form>


<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/validation.js"></script>
<script>
// $('input[type="submit"]').on('click', function(){
	
// 	var name = document.getElementsByName("name");
// 	console.log(name);


	
// });



</script>

</body>
</html>
