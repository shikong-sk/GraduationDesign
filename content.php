<?php

require_once  './Core/System/core.php';

session_start();

include_once './template/default/front/head.html';

include_once './template/default/front/h_nav.html'; // 顶部导航栏

if(isset($_REQUEST['channel']) && isset($_REQUEST['id']))
{
    echo "

<div id=\"content\">
			<el-row style=\"padding-top: 10px;\">
				<el-col :span=\"24\" class=\"text-center\">
					<h4>{{data.title}}</h4> 
				</el-col>
				<el-col :span=\"24\" class=\"text-center\">
					<h6>发布时间：{{data.date}}<span style=\"display: inline-block;width: 50px;\"> </span>已被阅读{{data.read}}次</h6> 
				</el-col>
				<el-col :span=\"24\">
					<el-card v-html=\"data.content\" shadow=\"never\" style=\"margin: 5px 5px;padding: 10px 10px 0 10px;\">
					</el-card>
				</el-col>
			</el-row>
		</div>

		<script>
			var resetWindow = function() {
				$('#content').css({
					'min-height': $(window).height() - $('#head').height() - $('#foot').height(),
					// 'paddingTop':$(this).height() / 2.5 
				})
			}
			$(document).ready(function() {
				resetWindow()
			})
			$(window).resize(function() {
				resetWindow()
			})
			
			var content = new Vue({
				el:\"#content\",
				data(){
					return {
						data:{
							title:'',
							date:'',
							content:'',
							read:''
						}
					}
				},
				mounted() {
					axios.post('/Core/Global/frontInit.php', Qs.stringify({
						\"getChannelData\": '',
						'channel': '".$_REQUEST['channel']."',
						'id': '".$_REQUEST['id']."'
					}), ).then(function(res) {
						if ('error' in res.data) {
							".'content.$alert'."(res.data.error, '错误', {
								center: true,
								confirmButtonText: '返回首页',
								callback: action => {
									window.location = 'index.php'
								}
							})
						} else {
							content.data = res.data[0]

						}
					})
				},
				methods:{
					
				}
			})
		</script>

    ";
}
else
{
    echo "
		<div id=\"content\">
			<h3 class=\"text-center\">该文章不存在</h3>
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