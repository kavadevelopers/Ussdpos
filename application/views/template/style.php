<style type="text/css">
    @media (min-width: 768px)
    {
        .modal-xl {
            width: 95%;
            max-width: 1350px;
        }    
    }
	.tbl-white-normal td{
        white-space: normal;
    }
	[data-khref] { cursor: pointer; }
	@media only screen and (max-width: 768px){
		.card-block.user-info {
		    position: inherit;
		    text-align: center;
		    background-repeat: no-repeat;
		    background: url(<?= base_url() ?>asset/assets/images/banner.jpg);
		    margin-bottom: 20px;
		}
		.profile-bg-img img.profile-bg-img{
			display: none;
		}
	}
	.link{
		color: #007bff;
	    text-decoration: none;
	    background-color: transparent;
	}
	.radio-togless-field{
		display: flex;
		/*margin-bottom: 36px;*/
		overflow: hidden;
	}

	.radio-togless-field input{
		position: absolute !important;
		clip: rect(0, 0, 0, 0);
		height: 1px;
		width: 1px;
		border: 0;
		overflow: hidden;
	}

	.radio-togless-field label {
		text-align: center;
		margin-right: 5px;
	}

	.radio-togless-field label span{
		padding: 8px 16px;
		background-color: #fff;
		display: block;
		color: #808080;
		font-size: 14px;
		line-height: 1;
		border-radius: 4px;
		border: 1px solid #ccc;
		transition: all 0.1s ease-in-out;
	}

	.radio-togless-field label:hover {
		cursor: pointer;
	}

	.radio-togless-field input:checked + span{
		background-color: #fe8e06;
		display: block;
		color: #fff;
		box-shadow: none;
	}
	.btn {
	    margin-top: 5px;
	}
	.h5-saparater{
        border-bottom: 1px solid #ccc;
        padding: 5px;
        margin-bottom: 10px;
        font-weight: 600;
    }
	.tb-row-image{
		width: 60px;
		border-radius: 50%;
	}
	/*::-webkit-scrollbar {
	display: none;
	}*/
	/*th, td {
	    white-space: normal;
	}*/
	.table-dt th,.table-dt td{
		white-space: normal;
	}
	.notifyMy li{
		padding: 2px 5px;
		border-bottom: 1px solid #ccc;
	}
	.notifyMy{
		max-height: 350px;
	    overflow-y: scroll !important;
	}
	.header-navbar .navbar-wrapper .navbar-container .header-notification .show-notification .notification-msg{
		margin-bottom: 0;
	}
	.main-body .page-wrapper {
    	padding: 5px;
    }
    .main-body .page-wrapper .page-header {
	    margin-bottom: 12px;
	}
	.dis-block{
		display: block;
	}
	.val-error{
		color: red;
	}
	.btn-mini i{
		margin-right: 0px;
	}
	.-req{
		color: red;
		font-weight: bold;
	}
	.card-footer{
		background-color: #f6f6f6 !important;
	}
	.form-group label{
		font-weight: bold; 
	}
	.select2-selection--single{
		    height: auto !important;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered {
		background: none;
	    color: #000;
	    padding: 0 10px 0;
	}
	.select2-container--default .select2-selection--single .select2-selection__arrow b{
		top: 20%;
		border-color:#888 transparent transparent transparent;
	}
	.m-t2{
		margin-top: 2px;
	}
	.datepicker table tr td.disabled,.datepicker table tr td.disabled:hover{
		color: #ccc;
	}
	.table-dt td, .table-dt th{
		padding: 5px;
	}

	.table-ndt td, .table-ndt th{
		padding: 5px;
	}
	.grid-images{
		width: auto;
	    height: 100px;
	    max-width: 100%;
	}

	.list-images{
		height: auto;
		max-height: 15px;
	}

	.list-image-span{
		margin: 0;
	    padding: 0;
	    margin-left: 5px;
	    margin-top: -4px;
	    width: 350px;
	}

	.table-no-padding td,.table-no-padding tH{
		padding: 5px;
	}

	.ajaxLoader{
		display: none;
		position: fixed;
	  	top: 0;
	  	bottom: 0%;
	  	left: 0;
	  	right: 0%;
	  	background-color: #cccccc87;
	  	z-index: 9999999999;
	}
	.ajaxLoader .loader{
		top: 50%;
	    position: absolute;
	    left: 50%;
	    right: 50%;
	    bottom: 50%;
	}
	.small-table-kava td,.small-table-kava th{
		padding: 5px;
	}

	.kava-form-group{
		margin-bottom: 0;
	}
	.view-p-kava{
		margin-bottom: 0;
	    padding-top: calc(.5rem - 1px * 2);
	    padding-bottom: calc(.5rem - 1px * 2);
	}
	.kava-bottom-border{
		border-bottom: 1px solid #ccc;
	}

</style>