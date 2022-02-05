<style>
	.go-top{
		z-index: 10000001!important;
		bottom: 0.7em!important;
	}
	.cookies-holder{
		position: fixed;
		bottom:0;
		left:0;
		background: rgba(51, 51, 51, 0.95);
		width: 100%;
		padding: 15px 0;
		z-index: 10000000;
	}
	.cookies-holder .container{
		background: transparent!important;
	}
	.cookies-holder .cookies{
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.cookies-holder .cookies .text{
		color:#fff;
		font-size: 1.4rem;
		/*font-weight: bold;*/
		margin: 0;
		margin-right: 30px;
	}
	.cookies-holder .cookies .text .terms{
		color:#ffca05;
	}
	.cookies-holder .cookies .text .terms:hover{
		text-decoration: underline;
	}
	.cookies-holder .cookies .links{
		color:#333;
		background: #ffca05;
		border-radius: 5px;
		font-size: 1.2rem;
		font-weight: bold;
		padding: 5px;
		margin-right: 65px;
	}
	.cookies-holder .cookies .links:hover{
		background: #FFE41F;
	}
	@media all and (max-width: 768px){
		.cookies-holder .cookies .text{
			font-size: 1.2rem;
			line-height: 1.3;
		}
	}
	@media all and (max-width: 499px){
		.cookies-holder .cookies{
			display: block;
		}
		.cookies-holder .cookies .text{
			margin-bottom: 10px;
		}
	}
</style>

<div class="cookies-holder">
	<div class="container-fluid">
		<div class="row _unmargin">
			<div class="col-md-12 col-seter">
				<div class="cookies">
					<p class="text"><?php echo $language["cookiesinfo"][1]; ?> <a href="uslovi_koriscenja_kolacica" class="terms"><?php echo $language["cookiesinfo"][2]; ?></a> <?php echo $language["cookiesinfo"][3]; ?></p>
					<a class="links cms_acceptCookiesBTN"><?php echo $language["cookiesinfo"][4]; ?></a>
				</div>
			</div>
		</div>
	</div>
</div>

