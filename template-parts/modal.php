<?php
/**
 * OC CA Theme - Quote Modal Template Part
 *
 * Renders the full-screen "Get a Quote" overlay modal
 * that is triggered by the navbar CTA button.
 *
 * @package OC_CA_Theme
 */
?>

<!-- GET A QUOTE OVERLAY MODAL -->
<div class="modal-overlay" id="quoteModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-card">
        <button class="modal-close-btn" id="closeQuoteModalBtn" aria-label="Close Modal">&times;</button>
        <div class="modal-header">
            <h3 id="modalTitle">Get an Instant Custom Quote</h3>
            <p>Please supply your details and our senior consultant will prepare a tailored estimate.</p>
        </div>
        <form id="modalQuoteForm" class="interactive-form">
            <div class="form-group">
                <label for="modalName"><i class="fa-solid fa-user"></i> Full Name</label>
                <input type="text" id="modalName" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="modalEmail"><i class="fa-solid fa-envelope"></i> Email Address</label>
                <input type="email" id="modalEmail" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="modalPhone"><i class="fa-solid fa-phone"></i> Phone Number</label>
                <input type="tel" id="modalPhone" name="phone" placeholder="Enter phone number" required>
            </div>
            <button type="submit" class="btn btn-primary btn-full">Submit Inquiry <i class="fa-solid fa-paper-plane"></i></button>
        </form>
        <div class="form-success" id="modalSuccess" style="display:none; text-align:center; padding: 30px 0;">
            <i class="fa-solid fa-circle-check" style="font-size: 3rem; color: var(--accent); margin-bottom: 1rem;"></i>
            <h4>Inquiry Submitted!</h4>
            <p>We have received your request. A senior partner will email/call you within 15 minutes.</p>
        </div>
    </div>
</div>
