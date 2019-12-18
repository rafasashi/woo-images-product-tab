<style>
	section {
		padding: 40px 0;
	}
    section h1{
        text-align: center;
        text-transform: uppercase;
        color: #ff9900;
        font-size: 40px;
        font-weight: 700;
        line-height: normal;
        display: inline-block;
        width: 100%;
        margin: 30px 0;
    }
    section:nth-child(even){
        background-color: #f7f7f7;
    }
    section:nth-child(odd){
        background-color: transparent;
    }
    section .section-title img{
        display: table-cell;
        vertical-align: middle;
        float: left;
        width: auto;
        margin-right: 15px;
    }
    section .section-title h2,.section .section-title h3
    {
        display: table-cell;
        vertical-align: middle;
        padding: 0;
        font-size: 30px;
        font-weight: 700;
        color: #2196f3;
        text-transform: uppercase;
        line-height: 28px;
    }

    section .section-title h3 {
        font-size: 14px;
        line-height: 28px;
        margin-bottom: 0;
        display: block;
    }

	section p {
		font-size: 20px;
		margin: 30px 0;
		color: #888;
	}
	
    section ul li{
        margin-bottom: 4px;
    }
		
    .landing-container{
        max-width: 95%;
        margin-left: auto;
        margin-right: auto;
        padding: 50px 0 30px;
    }
    .landing-container:after{
        display: block;
        clear: both;
        content: '';
    }
    .landing-container .col-1,
    .landing-container .col-2{
        float: left;
        box-sizing: border-box;
        padding: 0 15px;
    }
	.landing-container .col-1 img {
		width: 100%;
		box-shadow: 0 1px 3px 0 rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 2px 1px -1px rgba(0,0,0,.12);
		border-radius: 7px;
		border: 6px solid #dedede;
		margin-bottom: 15px;
	}
    .landing-container .col-1{
        width: 55%;
    }
    .landing-container .col-2{
        width: 45%;
    }
    .rew-license{
        background-color: #2196F3;
        color: #fff;
        border-radius: 5px;
        padding: 30px;
		box-shadow: 0 1px 3px 0 rgba(0,0,0,.2), 0 1px 1px 0 rgba(0,0,0,.14), 0 2px 1px -1px rgba(0,0,0,.12);
    }
    .rew-license:after{
        content: '';
        display: block;
        clear: both;
    }
    .rew-license p{
		color: #fff;
        margin: 0;
        font-size: 20px;
        font-weight: 500;
        display: inline-block;
        width: 60%;
    }
    .rew-license a.button{
        border-radius: 6px;
        height: 60px;
        float: right;
        background: url(<?php echo $this->parent->assets_url . 'images/'?>upgrade.png?123) #ff9900 no-repeat 13px 13px;
        border-color: #b97e26;
        box-shadow: none;
        outline: none;
        color: #fff;
        position: relative;
        padding: 9px 50px 9px 70px;
    }
    .rew-license a.button:hover,
    .rew-license a.button:active,
    .rew-license a.button:focus{
        color: #fff;
        background: url(<?php echo $this->parent->assets_url . 'images/'?>upgrade-hover.png) #ff8822 no-repeat 13px 13px;
        border-color: #971d00;
        box-shadow: none;
        outline: none;
    }
    .rew-license a.button:focus{
        top: 1px;
    }
    .rew-license a.button span{
        line-height: 13px;
    }
    .rew-license a.button .highlight{
        display: block;
        font-size: 23px;
        font-weight: 700;
        line-height: 20px;
    }
    .rew-license .highlight{
        text-transform: uppercase;
        background: none;
        font-weight: 800;
        color: #fff;
    }

    @media (max-width: 767px){
        section{
            margin-left: 0;
            margin-right: 0;
        }
        .rew-license a.button{
            float: none;
        }
        .rew-license{
            text-align: center;
        }
        .rew-license p{
            width: 100%;
        }
    }

    @media (max-width: 480px){
        .wrap{
            margin-right: 0;
        }
        section{
            margin: 0;
        }
	
        .landing-container .col-1,
        .landing-container .col-2{
            width: 100%;
            padding: 0 15px;
        }
        .section-odd .col-1 {
            float: left;
            margin-right: -100%;
        }
        .section-odd .col-2 {
            float: right;
            margin-top: 65%;
        }
    }

    @media (max-width: 320px){
        .rew-license a.button{
            padding: 9px 20px 9px 70px;
        }
		
        section .section-title img{
            display: none;
        }
    }
</style>
<div class="landing">
	
	<section class="section-rew section-odd" style="padding-top:0;">
		<div class="landing-container">
			<div class="rew-license">
				<p>
					Upgrade to the <span class="highlight">premium version</span>
					of <span class="highlight">WooCommerce Images Product Tab</span> to benefit from all features!
				</p>
				<a href="<?php echo $this->parent->premium_url; ?>" target="_blank" class="rew-license-button button btn">
					<span class="highlight">GET LICENSE</span>
					<span>to the premium version</span>
				</a>
			</div>
		</div>
	</section>
	
    <section class="section-even clear" style="background: url(<?php echo $this->parent->assets_url . 'images/'?>01-bg.png?<?php echo time(); ?>) no-repeat #f7f7f7; background-position: 85% 75%">
        <h1>Premium Features</h1>
		
        <div class="landing-container">
		
            <div class="col-1">
				<a href="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-1.png">
					<img src="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-1.png?<?php echo time(); ?>" alt="Review Title" />
				</a>
			</div>
            <div class="col-2">
                <div class="section-title">
					<img src="<?php echo $this->parent->assets_url . 'images/' ?>01-icon.png?<?php echo time(); ?>" alt="Screenshot Option"/>
					<h2>TAB SETTINGS</h2>
                </div>
                <p>Manage the tab settings from the Woocommerce settings and select the image size, tab name or enable the lightbox.</p>
            </div>
        </div>
    </section>
    <section class="section-odd clear" style="background: url(<?php echo $this->parent->assets_url . 'images/'?>02-bg.png?<?php echo time(); ?>) no-repeat transparent; background-position: 15% 90%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo $this->parent->assets_url . 'images/' ?>02-icon.png?<?php echo time(); ?>" alt="Screenshot Loader" />
                    <h2>RENAME THE TAB</h2>
                </div>
                <p>Don't keep the tab name "images" and rename the tab to anything you want like "screenshots" or "gallery".</p>
            </div>
            <div class="col-1">
				<a href="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-2.png">
					<img src="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-2.png?<?php echo time(); ?>" alt="Attachment List" />
				</a>
			</div>
        </div>
    </section>
    <section class="section-even clear" style="background: url(<?php echo $this->parent->assets_url . 'images/'?>03-bg.png?<?php echo time(); ?>) no-repeat #f7f7f7; background-position: 85% 90%">
        <div class="landing-container">
            <div class="col-1">
				<a href="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-3.png">
					<img src="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-3.png?<?php echo time(); ?>" alt="03" />
				</a>
			</div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo $this->parent->assets_url . 'images/' ?>03-icon.png?<?php echo time(); ?>" alt="Pagination" />
                    <h2>ENABLE THE LIGHBOX</h2>
                </div>
                <p>Highlight your product image by activating a lightbox when a customer clicks on it. It works on all modern browsers.</p>
            </div>
        </div>
    </section>
    <section class="section-odd clear" style="background: url(<?php echo $this->parent->assets_url . 'images/'?>04-bg.png?<?php echo time(); ?>) no-repeat transparent; background-position: 15% 90%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo $this->parent->assets_url . 'images/' ?>04-icon.png?<?php echo time(); ?>" alt="Loading Effect" />
                    <h2>DISABLE IMAGES TAB</h2>
                </div>
                <p>Diable images tab for some products only using the checkbox in the general settings of the product.</p>
            </div>
            <div class="col-1">
				<a href="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-4.png">
					<img src="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-4.png?<?php echo time(); ?>" alt="Loading Effect" />
				</a>
			</div>
        </div>
    </section>

    <section class="section-even clear" style="background: url(<?php echo $this->parent->assets_url . 'images/'?>05-bg.png?<?php echo time(); ?>) no-repeat #f7f7f7; background-position: 85% 90%">
        <div class="landing-container">
            <div class="col-1">
				<a href="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-5.png">
					<img src="<?php echo $this->parent->assets_url . 'images/' ?>screenshot-5.png?<?php echo time(); ?>" alt="05" />
				</a>
			</div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo $this->parent->assets_url . 'images/' ?>05-icon.png?<?php echo time(); ?>" alt="Pagination" />
                    <h2>SELECT IMAGES SIZE</h2>
                </div>
                <p>
                    Select between thumbnail, medium, large or full to change the size of the images displayed under the product tab.
                </p>
            </div>
        </div>
    </section>
	
	<?php if( !$this->parent->license->is_valid() ){ ?>
	
		<section class="section-rew section-odd">
			<div class="landing-container">
				<div class="rew-license">
					<p>
						Upgrade to the <span class="highlight">premium version</span>
						of <span class="highlight">WooCommerce Images Product Tab</span> to benefit from all features!
					</p>
					<a href="<?php echo $this->parent->premium_url; ?>" target="_blank" class="rew-license-button button btn">
						<span class="highlight">GET LICENSE</span>
						<span>to the premium version</span>
					</a>
				</div>
			</div>
		</section>
		
	<?php } ?>
	
</div>
