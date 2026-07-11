<?php
/**
 * OC CA Theme - Sidebar Cards Template Part
 *
 * Renders the sticky consultation form card and
 * "Why ANBCA" trust card for the right sidebar column.
 *
 * @package OC_CA_Theme
 */
?>

<div class="sidebar-column">

    <!-- Card 1: Free Consultation Form -->
    <div class="sidebar-card">
        <h4><i class="fa-solid fa-comments" style="color:var(--primary);margin-right:8px;"></i> Get Free Consultation</h4>
        <p>Speak directly with a senior Chartered Accountant. Leave your details and we'll call you right away.</p>
        <form class="interactive-form sidebar-form" id="sidebarConsultForm">
            <div class="form-group">
                <input type="text" name="name" placeholder="Your Name" required>
            </div>
            <div class="form-group">
                <input type="tel" name="phone" placeholder="Phone Number" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <button type="submit" class="btn btn-primary btn-full">
                Request Callback <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
        <div class="form-success" id="sidebarConsultSuccess" style="display:none; text-align:center; padding:20px 0;">
            <i class="fa-solid fa-circle-check" style="font-size:2.5rem;color:var(--success);margin-bottom:0.7rem;display:block;"></i>
            <h4>Sent!</h4>
            <p>Our expert will call you shortly.</p>
        </div>
    </div>

    <!-- Card 2: Why ANBCA Trust Points -->
    <div class="sidebar-card why-card">
        <h4><i class="fa-solid fa-shield-halved" style="color:var(--primary);margin-right:8px;"></i> Why A N Bhutada &amp; Co?</h4>
        <ul class="why-list">
            <li><i class="fa-solid fa-check-circle"></i> 15+ Years of Expertise</li>
            <li><i class="fa-solid fa-check-circle"></i> 1000+ Satisfied Clients</li>
            <li><i class="fa-solid fa-check-circle"></i> 50+ Services Under One Roof</li>
            <li><i class="fa-solid fa-check-circle"></i> 100% Confidentiality</li>
            <li><i class="fa-solid fa-check-circle"></i> Timely Filing Guarantee</li>
            <li><i class="fa-solid fa-check-circle"></i> Senior CA Advisor Support</li>
            <li><i class="fa-solid fa-check-circle"></i> Transparent Pricing</li>
        </ul>
    </div>

</div>
