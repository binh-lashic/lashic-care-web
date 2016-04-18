		<!-- content start 基本情報変更 -->
		<section id="contentBoxLarge">
			<form class="form">
				<h1 class="contentLarge_h1">見守り対象ユーザー　基本情報変更入力</h1>
				<p>変更したい内容を入力してください。</p>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<div class="form_set_container">
						<div class="userDate_photo">
							<div class="aside_photo">
								<div class="aside_photoInner"><img src="../images/common/img_no-image.jpg" width="179" height="179" alt=""/></div>
							</div>
									<div class="uploadButton btn_text">ファイルを選択<br>
（最大00MB）
										<input type="file" onChange="uv.style.display='inline-block'; uv.value = this.value;" />
										<input type="text" id="uv" class="uploadValue" disabled />
									</div>
						</div>
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th><span class="icon_Required">必須</span> お名前</th>
										<td><input type="text" class="input_text input_medium" value="<?php echo $client['name']; ?>"></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> ふりがな</th>
										<td><input type="text" class="input_text input_medium" value="<?php echo $client['kana']; ?>"></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 性別</th>
										<td>
											<input type="radio" id="male" name="sex" <?php if($client['gender'] == "m") { echo " checked=\"checked\""; } ?>>
											<label for="male" class="checkbox">男性</label>
											<input type="radio" id="female" name="sex" <?php if($client['gender'] == "f") { echo " checked=\"checked\""; } ?>>
											<label for="female" class="checkbox">女性</label></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 生年月日</th>
										<td>
											<div class="clearfix">
												<div class="floatL common_select">
													<select>
														<option value="1900">1900/明治33</option>
														<option value="1901">1901/明治34</option>
														<option value="1902">1902/明治35</option>
														<option value="1903">1903/明治36</option>
														<option value="1904">1904/明治37</option>
														<option value="1905">1905/明治38</option>
														<option value="1906">1906/明治39</option>
														<option value="1907">1907/明治40</option>
														<option value="1908">1908/明治41</option>
														<option value="1909">1909/明治42</option>
														<option value="1910">1910/明治43</option>
														<option value="1911">1911/明治44</option>
														<option value="1912">1912/大正元</option>
														<option value="1913">1913/大正2</option>
														<option value="1914">1914/大正3</option>
														<option value="1915">1915/大正4</option>
														<option value="1916">1916/大正5</option>
														<option value="1917">1917/大正6</option>
														<option value="1918">1918/大正7</option>
														<option value="1919">1919/大正8</option>
														<option value="1920">1920/大正9</option>
														<option value="1921">1921/大正10</option>
														<option value="1922">1922/大正11</option>
														<option value="1923">1923/大正12</option>
														<option value="1924">1924/大正13</option>
														<option value="1925">1925/大正14</option>
														<option value="1926">1926/大正15</option>
														<option value="1927">1927/昭和2</option>
														<option value="1928">1928/昭和3</option>
														<option value="1929">1929/昭和4</option>
														<option value="1930">1930/昭和5</option>
														<option value="1931">1931/昭和6</option>
														<option value="1932">1932/昭和7</option>
														<option value="1933">1933/昭和8</option>
														<option value="1934">1934/昭和9</option>
														<option value="1935">1935/昭和10</option>
														<option value="1936">1936/昭和11</option>
														<option value="1937">1937/昭和12</option>
														<option value="1938">1938/昭和13</option>
														<option value="1939">1939/昭和14</option>
														<option value="1940">1940/昭和15</option>
														<option value="1941">1941/昭和16</option>
														<option value="1942">1942/昭和17</option>
														<option value="1943">1943/昭和18</option>
														<option value="1944">1944/昭和19</option>
														<option value="1945" selected>1945/昭和20</option>
														<option value="1946">1946/昭和21</option>
														<option value="1947">1947/昭和22</option>
														<option value="1948">1948/昭和23</option>
														<option value="1949">1949/昭和24</option>
														<option value="1950">1950/昭和25</option>
														<option value="1951">1951/昭和26</option>
														<option value="1952">1952/昭和27</option>
														<option value="1953">1953/昭和28</option>
														<option value="1954">1954/昭和29</option>
														<option value="1955">1955/昭和30</option>
														<option value="1956">1956/昭和31</option>
														<option value="1957">1957/昭和32</option>
														<option value="1958">1958/昭和33</option>
														<option value="1959">1959/昭和34</option>
														<option value="1960">1960/昭和35</option>
														<option value="1961">1961/昭和36</option>
														<option value="1962">1962/昭和37</option>
														<option value="1963">1963/昭和38</option>
														<option value="1964">1964/昭和39</option>
														<option value="1965">1965/昭和40</option>
														<option value="1966">1966/昭和41</option>
														<option value="1967">1967/昭和42</option>
														<option value="1968">1968/昭和43</option>
														<option value="1969">1969/昭和44</option>
														<option value="1970">1970/昭和45</option>
														<option value="1971">1971/昭和46</option>
														<option value="1972">1972/昭和47</option>
														<option value="1973">1973/昭和48</option>
														<option value="1974">1974/昭和49</option>
														<option value="1975">1975/昭和50</option>
														<option value="1976">1976/昭和51</option>
														<option value="1977">1977/昭和52</option>
														<option value="1978">1978/昭和53</option>
														<option value="1979">1979/昭和54</option>
														<option value="1980">1980/昭和55</option>
														<option value="1981">1981/昭和56</option>
														<option value="1982">1982/昭和57</option>
														<option value="1983">1983/昭和58</option>
														<option value="1984">1984/昭和59</option>
														<option value="1985">1985/昭和60</option>
														<option value="1986">1986/昭和61</option>
														<option value="1987">1987/昭和62</option>
														<option value="1988">1988/昭和63</option>
														<option value="1989">1989/平成元</option>
														<option value="1990">1990/平成2</option>
														<option value="1991">1991/平成3</option>
														<option value="1992">1992/平成4</option>
														<option value="1993">1993/平成5</option>
														<option value="1994">1994/平成6</option>
														<option value="1995">1995/平成7</option>
														<option value="1996">1996/平成8</option>
														<option value="1997">1997/平成9</option>
														<option value="1998">1998/平成10</option>
														<option value="1999">1999/平成11</option>
														<option value="2000">2000/平成12</option>
														<option value="2001">2001/平成13</option>
														<option value="2002">2002/平成14</option>
														<option value="2003">2003/平成15</option>
														<option value="2004">2004/平成16</option>
														<option value="2005">2005/平成17</option>
														<option value="2006">2006/平成18</option>
														<option value="2007">2007/平成19</option>
														<option value="2008">2008/平成20</option>
														<option value="2009">2009/平成21</option>
														<option value="2010">2010/平成22</option>
														<option value="2011">2011/平成23</option>
														<option value="2012">2012/平成24</option>
														<option value="2013">2013/平成25</option>
														<option value="2014">2014/平成26</option>
														<option value="2015">2015/平成27</option>
														<option value="2016">2016/平成28</option>
													</select>
												</div>
												<div class="floatL pdt5">　年　</div>
												<div class="floatL common_select">
													<select>
														<option value="">選択してください</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
													</select>
												</div>
												<div class="floatL pdt5">　月　</div>
												<div class="floatL common_select">
													<select>
														<option value="">選択してください</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
														<option value="24">24</option>
														<option value="25">25</option>
														<option value="26">26</option>
														<option value="27">27</option>
														<option value="28">28</option>
														<option value="29">29</option>
														<option value="30">30</option>
														<option value="31">31</option>
													</select>
												</div>
												<div class="floatL pdt5">　日</div>
											</div>
										</td>
									</tr>
									<tr>
										<th>血液型</th>
										<td>
											<div class="clearfix">
												<div class="floatL common_select">
													<select>
														<option value="">選択してください</option>
														<option value="A">A</option>
														<option value="A(Rh-)">A(Rh-)</option>
														<option value="B">B</option>
														<option value="B(Rh-)">B(Rh-)</option>
														<option value="O">O</option>
														<option value="1">O(Rh-)</option>
														<option value="1">AB</option>
														<option value="1">AB(Rh-)</option>
													</select>
												</div>
												<div class="floatL pdt5">　型　<span class="small text_red">※緊急時に役立てます。できるだけご記入ください。</span></div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<!-- /基本情報 --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end 基本情報変更 --> 