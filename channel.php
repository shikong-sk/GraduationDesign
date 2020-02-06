<?php

session_start();

include_once './template/default/front/head.html';

include_once './template/default/front/h_nav.html'; // 顶部导航栏

if(isset($_REQUEST['channel']))
{
    echo "
    		<div id=\"channel\">
			<el-tabs tab-position=\"top\" style=\"\">
				<el-tab-pane label=\"\">

					<div v-for=\"data in channelData\" :key=\"data.id\">
						<el-row>
							<el-col :span=\"20\">
								<a target=\"_blank\" :href=\"'content.php?channel=".$_REQUEST['channel']."&id=' + data.id \">{{data.title}}</a>
							</el-col>
							<el-col :span=\"4\" style=\"text-overflow: ellipsis;overflow: hidden;\">
								{{data.date}}

							</el-col>
						</el-row>

					</div>

					<el-pagination @size-change=\"\" @current-change=\"(v)=>{handleCurrentChange(v,'message')}\" :current-page.sync=\"channelPage\"
					 :page-size=\"10\" layout=\"prev, pager, next, jumper\" :total=\"parseInt(channelCount)\">
					</el-pagination>

				</el-tab-pane>

			</el-tabs>
		</div>


		<script type=\"text/javascript\">
			var resetWindow = function() {
				$('#setting').css({
					'min-height': $(window).height() - $('#head').height() - $('#foot').height()
				})
				$('#channel').css({
					'min-height': $(window).height() - $('#head').height() - $('#foot').height()
				})
				if ($(window).width() <= 995) {
					channel.tabPosition = 'top'
					$('#channel').css({
						'margin': '0 10px',
						'margin-top': '5px'
					})
				} else {
					channel.tabPosition = 'left'
					$('#channel').css({
						'margin': '0 5px',
						'margin-top': '5px'
					})
				}
			}
			$(document).ready(function() {
				resetWindow()
			})
			$(window).resize(function() {
				resetWindow()
			})

			var channel = new Vue({
				el: '#channel',
				data() {

					return {

						tabPosition: 'left',

						channelData: {
							messageData: [''],
						},

						channelCount: 0,
						channelPage: 1,
					}

				},
				mounted() {

					axios.post('/Core/Global/frontInit.php', Qs.stringify({
						\"getChannelCount\": '".$_REQUEST['channel']."'
					}), ).then(function(res) {
						channel.channelCount = res.data.num
					})

					axios.post('/Core/Global/frontInit.php', Qs.stringify({
						\"getChannelTitle\": '".$_REQUEST['channel']."',
						'page': '1',
						'num': '10'
					}), ).then(function(res) {
						channel.channelData = res.data
					})

				},
				watch: {},
				computed: {},
				methods: {
					handleCurrentChange(val, c) {
						axios.post('/Core/Global/frontInit.php', Qs.stringify({
							\"getChannelTitle\": c,
							'page': val,
							'num': '10'
						}), ).then(function(res) {
							channel.channelData = res.data
						})
					},
				}
			})

			var loadChannelData = function() {
				axios.post('/Core/Global/frontInit.php', Qs.stringify({
					\"getChannelTitle\": '".$_REQUEST['channel']."',
					'page': channel.channelPage,
					'num': '10'
				}), ).then(function(res) {
					channel.channelData = res.data
				})

				axios.post('/Core/Global/frontInit.php', Qs.stringify({
					\"getChannelCount\": '".$_REQUEST['channel']."'
				}), ).then(function(res) {
					channel.channelCount = res.data.num
				})

			}
		</script>
    ";
}
else
{
    echo "
		<div id=\"content\">
			<h3 class=\"text-center\">该频道不存在</h3>
			<p class=\"text-center\">
				<a href=\"index.php\">返回首页</a>
			</p> 
		</div>

		<script>
			var resetWindow = function() {
				$('#content').css({
					'height': $(window).height() - $('#head').height() - $('#foot').height(),
					'paddingTop':$(this).height() / 2.5 
				})
			}
			$(document).ready(function() {
				resetWindow()
			})
			$(window).resize(function() {
				resetWindow()
			})
		</script>
    ";
}

include_once './template/default/front/foot.html';