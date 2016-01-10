 <!DOCTYPE html>
 <html lang="ja">
 <head>
 	<meta charset="UTF-8">
 	<title>コンタクトフォーム</title>
 </head>
 <body>
 <style type="text/css">
	label{
		width: 100px;
		height: 30px;
		display: inline-block;
	}
	.form__message label{
		vertical-align: top;
	}
 </style>


 <form method="post" action="check.php">
    <div class="form__name form">
        <label for="name">お名前</label>
        <input type="text" placeholder="your name" id="name" name="name">
    </div>
    <div class="form__email form">
        <label for="email">Email</label>
        <input type="email" placeholder="mail address" id="email" name="email">
    </div>
    <div class="form__phone form">
        <label for="phone">電話番号</label>
        <input type="tel" placeholder="phone number" id="phone" name="phone">
    </div>
    <div class="form__age form">
        <label for="age">年齢</label>
        <select id="age" name="age">
			<option value="" selected>年齢</option>
			<option value="10">10歳</option>
			<option value="11">11歳</option>
			<option value="12">12歳</option>
			<option value="13">13歳</option>
			<option value="14">14歳</option>
			<option value="15">15歳</option>
			<option value="16">16歳</option>
			<option value="17">17歳</option>
			<option value="18">18歳</option>
			<option value="19">19歳</option>
			<option value="20">20歳</option>
			<option value="21">21歳</option>
			<option value="22">22歳</option>
			<option value="23">23歳</option>
			<option value="24">24歳</option>
			<option value="25">25歳</option>
			<option value="26">26歳</option>
			<option value="27">27歳</option>
			<option value="28">28歳</option>
			<option value="29">29歳</option>
			<option value="30">30歳</option>
			<option value="31">31歳</option>
			<option value="32">32歳</option>
			<option value="33">33歳</option>
			<option value="34">34歳</option>
			<option value="35">35歳</option>
			<option value="36">36歳</option>
			<option value="37">37歳</option>
			<option value="38">38歳</option>
			<option value="39">39歳</option>
			<option value="40">40歳</option>
			<option value="41">41歳</option>
			<option value="42">42歳</option>
			<option value="43">43歳</option>
			<option value="44">44歳</option>
			<option value="45">45歳</option>
			<option value="46">46歳</option>
			<option value="47">47歳</option>
			<option value="48">48歳</option>
			<option value="49">49歳</option>
			<option value="50">50歳</option>
			<option value="51">51歳</option>
			<option value="52">52歳</option>
			<option value="53">53歳</option>
			<option value="54">54歳</option>
			<option value="55">55歳</option>
			<option value="56">56歳</option>
			<option value="57">57歳</option>
			<option value="58">58歳</option>
			<option value="59">59歳</option>
			<option value="60">60歳</option>
			<option value="61">61歳</option>
			<option value="62">62歳</option>
			<option value="63">63歳</option>
			<option value="64">64歳</option>
			<option value="65">65歳</option>
			<option value="66">66歳</option>
			<option value="67">67歳</option>
			<option value="68">68歳</option>
			<option value="69">69歳</option>
			<option value="70">70歳</option>
			<option value="71">71歳</option>
			<option value="72">72歳</option>
			<option value="73">73歳</option>
			<option value="74">74歳</option>
			<option value="75">75歳</option>
			<option value="76">76歳</option>
			<option value="77">77歳</option>
			<option value="78">78歳</option>
			<option value="79">79歳</option>
			<option value="80">80歳</option>
			<option value="81">81歳</option>
			<option value="82">82歳</option>
			<option value="83">83歳</option>
			<option value="84">84歳</option>
			<option value="85">85歳</option>
			<option value="86">86歳</option>
			<option value="87">87歳</option>
			<option value="88">88歳</option>
			<option value="89">89歳</option>
			<option value="90">90歳</option>
			<option value="91">91歳</option>
			<option value="92">92歳</option>
			<option value="93">93歳</option>
			<option value="94">94歳</option>
			<option value="95">95歳</option>
			<option value="96">96歳</option>
			<option value="97">97歳</option>
			<option value="98">98歳</option>
			<option value="99">99歳</option>
			<option value="100">100歳</option>
		</select>
    </div>
    <div class="form__message form">
        <label for="message">メッセージ</label>
        <textarea rows="5" placeholder="message" id="message" name="message"></textarea>
    </div>

    <button type="submit">確認</button>
</form>    
 	
 </body>
 </html>