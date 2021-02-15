<ul>
    @if(config('settings.config_social_fb_url'))
        <li>
            <a href="{{ config('settings.config_social_fb_url') }}" target="_blank">
                <i class="fa fa-facebook"></i>
            </a>
        </li>
    @endif
    @if(config('settings.config_social_twitter_url'))
        <li>
            <a href="{{ config('settings.config_social_twitter_url') }}" target="_blank">
                <i class="fa fa-twitter"></i>
            </a>
        </li>
    @endif
    @if(config('settings.config_social_instagram_url'))
        <li>
            <a href="{{ config('settings.config_social_instagram_url') }}" target="_blank">
                <i class="fa fa-instagram"></i>
            </a>
        </li>
    @endif
    @if(config('settings.config_social_linkedin_url'))
        <li>
            <a href="{{ config('settings.config_social_linkedin_url') }}" target="_blank">
                <i class="fa fa-linkedin"></i>
            </a>
        </li>
    @endif
    @if(config('settings.config_social_behance_url'))
        <li>
            <a href="{{ config('settings.config_social_behance_url') }}" target="_blank">
                <i class="fa fa-behance"></i>
            </a>
        </li>
    @endif
</ul>