<footer class="footer" style="background-image:url('{{ asset('images/footer-bg.jpg') }}')">
    <div class="footer__inner">
        <div class="footer__cols">
            <div><h4>CHARTER</h4>
                <a href="{{ route('charter') }}">Charter a yacht</a><a href="{{ route('yachts.index') }}">Yacht profiles</a>
                <a href="{{ route('destinations') }}">Destinations</a><a href="{{ route('sell') }}">Sell a yacht</a></div>
            <div><h4>SERVICES</h4>
                <a href="{{ route('management') }}">Yacht management</a><a href="{{ route('crew') }}">Crew services</a>
                <a href="{{ route('build') }}">Build</a><a href="{{ route('design') }}">Design</a></div>
            <div><h4>COMPANY</h4>
                <a href="{{ route('about') }}">About us</a><a href="{{ route('news') }}">News</a>
                <a href="{{ route('careers') }}">Careers</a><a href="{{ route('contact') }}">Contact</a></div>
        </div>

        <form class="footer__news" method="POST" action="{{ route('newsletter.subscribe') }}">
            @csrf
            <p>STAY INSPIRED. FOR EXCLUSIVE UPDATES &amp; THE LATEST FROM THE WORLD OF YACHTING</p>
            @if (session('newsletter_subscribed')) <p class="footer__notice">{{ session('newsletter_subscribed') }}</p> @endif
            <div class="footer__field">
                <input id="newsletter-email" name="newsletter_email" type="email" placeholder="Your email address" aria-label="Email" value="{{ old('newsletter_email') }}" required>
                <button type="submit">SIGN UP</button>
            </div>
            @error('newsletter_email')<em class="footer__error">{{ $message }}</em>@enderror
            <div class="footer__social">
                <span aria-label="Instagram">IG</span><span aria-label="Facebook">FB</span>
                <span aria-label="LinkedIn">IN</span><span aria-label="YouTube">YT</span>
            </div>
        </form>
    </div>
    <details class="footer__credits">
        <summary>PHOTOGRAPHY CREDITS &amp; LICENSES</summary>
        <p>All photographs are optimized and stored locally. Wikimedia Commons images have been resized or compressed for the site and are credited under their linked Creative Commons licenses; Unsplash images are used under the Unsplash License.</p>
        <ul>
            <li><a href="https://commons.wikimedia.org/wiki/File:Luxury_motor_yacht_Ocean_Pearl.jpg" rel="noopener">Ocean Pearl — martinvarsavsky, CC BY 2.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Luxury_yacht.jpg" rel="noopener">Luxury yacht — Getsijas, CC BY-SA 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Lady_Lau_super-yacht_IMO_1010674_Bonifacio.jpg" rel="noopener">Lady Lau at Bonifacio — Myrabella, CC BY-SA 3.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Motor_yacht_Sunrays_in_Istanbul,_March_2024_01.jpg" rel="noopener">Motor yacht Sunrays — Calistemon, CC BY-SA 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Sirena_88_in_Port_of_Rhodes_29_July_2025.jpg" rel="noopener">Sirena 88 — Pjotr Mahhonin, CC BY-SA 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Le_yacht_de_luxe_IJE_(IMO_1013004)_%C3%A0_quai_%C3%A0_Monaco_(4_novembre_2021).jpg" rel="noopener">IJE at Monaco — Benoît Prieur, CC0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Princess_Svanevit_at_Stadshusregattan_-_Stockholm_City_Hall_Regatta_16-18_June_2023_02.jpg" rel="noopener">Princess Svanevit — Sinikka Halme, CC BY-SA 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Sailing_boat_at_sunset,_Ionian_Sea,_Albania.jpg" rel="noopener">Sailing boat at sunset — Liridon, CC BY-SA 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Amalfi_Coast_(Italy,_October_2020)_-_51_(50558487597).jpg" rel="noopener">Amalfi Coast — Bruno Rijsman, CC BY-SA 2.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Golfo_di_Napoli_in_blue.jpg" rel="noopener">Gulf of Naples — Tesla Delacroix, CC BY-SA 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Deerfoot_65_foot_yacht_Interior_by_Don_Ramey_Logan.jpg" rel="noopener">Deerfoot yacht interior — Don Ramey Logan, CC BY-SA 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Y_712_(31890325783).jpg" rel="noopener">Y712 project — Kees Torn, CC BY-SA 2.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Motor_yacht_%27Davina%27_in_Sozopol_port.jpg" rel="noopener">Motor yacht Davina — Biser Todorov, CC BY 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Golden_Odyssey_L%C3%BCrssen.jpg" rel="noopener">Golden Odyssey — DrDuu, CC BY-SA 4.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Interior_of_Yacht_Endeavour_showcasing_a_replica_of_J-class_sailboat_Ranger_transom_Don_Ramey_Logan.jpg" rel="noopener">Yacht Endeavour interior — Don Ramey Logan, CC BY-SA 3.0</a></li>
            <li><a href="https://commons.wikimedia.org/wiki/File:Yacht_azulon_interior.JPG" rel="noopener">Yacht Azulon interior — Marionsebel, CC BY-SA 3.0</a></li>
        </ul>
    </details>
    <p class="footer__legal">&copy; {{ date('Y') }} Luxora Yachts. All rights reserved. Website created by Dhyey Mahida and Rahil Adreja.</p>
</footer>
