 <!-- Masthead-->
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4" style="background: #0000002e;">
                    	 <h1 class="text-uppercase text-white font-weight-bold">About Us</h1>
                        <hr class="divider my-4" />
                    </div>
                    
                </div>
            </div>
        </header>

    <section class="page-section">
        <div class="container about-content" style="max-width: 1000px;">
            <?php echo html_entity_decode($_SESSION['setting_about_content']) ?>        
        </div>
    </section>

<style>
.about-content {
    font-size: 1rem;
    line-height: 1.6;
    word-break: break-word;
    white-space: pre-line;
}
</style>