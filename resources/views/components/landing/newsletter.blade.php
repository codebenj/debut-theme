<div class='card bg-primary p-3 shadow {{$class??''}}'>
    <div class='card-body bg-white rounded px-4'>
        <div class='text-center'>
            <h4 class='font-weight-bold'> {{$nbShops}}+ Are Reading  The Debutify Newsletter.</h4>
              <div class="responsive-container-16by9">
                <img class="lazyloaded" data-src="/images/landing/graph_mail.svg" src="/images/landing/graph_mail.svg">
              </div>
            <p class='my-3'>Get bite-sized lessons from leading experts in the world of e-commerce.  Improve your business in 5 minutes a week. Subscribe today:</p>
        </div>
        <form id='defaultNewsletter' >
          <div class='form-group'>
            <input type="email" class='form-control form-control-sm mb-3' name='email' placeholder="Email address" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required>
          </div>
            <button type="submit" class='btn btn-sm btn-block btn-primary mb-3'>Subscribe</button>
          <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="defaultNewsletterCheckbox" name="" required>
              <label class="custom-control-label" for="defaultNewsletterCheckbox"> I agree to receive regular updates from Debutify. <a href="/privacy-policy"> View Privacy Policy here.</a></label>
          </div>
        </form>
    </div>
</div>
