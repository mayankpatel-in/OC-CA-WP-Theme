<?php
/**
 * OC CA Theme - Reviewed By Author Box
 *
 * Fixed reviewer credit shown at the end of every page and post.
 *
 * @package OC_CA_Theme
 */

$oc_ca_reviewer_linkedin = get_theme_mod( 'footer_li_url', '#' );
?>
<div class="reviewed-by-box">
    <div class="reviewed-by-avatar">
        <img
            src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/team/amit-bhutada-reviewer.jpg' ); ?>"
            alt="CA Amit Bhutada"
            loading="lazy"
            width="110"
            height="110"
        >
    </div>
    <div class="reviewed-by-content">
        <span class="reviewed-by-label"><?php esc_html_e( 'Reviewed By', 'oc-ca-theme' ); ?></span>
        <h3 class="reviewed-by-name">CA Amit Bhutada</h3>
        <p>CA Amit Bhutada is a Chartered Accountant with over 10 years of professional experience in taxation, accounting, audit, corporate compliance, and business advisory. As the Founder of A N Bhutada &amp; Co., he assists startups, SMEs, established businesses, and international clients in setting up and managing their operations in India while ensuring compliance with the Income-tax Act, GST laws, the Companies Act, and other regulatory requirements.</p>
        <p>He has advised businesses across diverse industries on company incorporation, GST, ROC compliance, accounting systems, tax planning, and regulatory matters. His practical, solution-oriented approach enables entrepreneurs and business owners to make informed decisions and stay compliant throughout every stage of their business lifecycle.</p>
        <a href="<?php echo esc_url( $oc_ca_reviewer_linkedin ); ?>" class="reviewed-by-social" target="_blank" rel="noopener noreferrer" aria-label="CA Amit Bhutada on LinkedIn">
            <i class="fa-brands fa-linkedin-in"></i>
        </a>
    </div>
</div>
