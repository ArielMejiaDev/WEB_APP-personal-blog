@component('mail::message')
# Hi

Thanks for contact me.

I am excited to help companies with my software development skills,
I would love to know more about this opportunity,
you can contact me by replying to this email or also download my CV by clicking on the download button
or visit my site <a href="https://arielmejia.dev" target="_blank">here</a>

@component('mail::button', ['url' => 'https://bit.ly/2WIaTvB'])
Download CV
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
