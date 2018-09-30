<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="{{ config('services.twitter.username') }}" />
<meta name="twitter:creator" content="{{ config('services.twitter.username') }}" />

<meta property="fb:app_id"      content="{{ config('services.facebook.client_id') }}" />
<meta property="og:url"         content="{{ url()->current() }}" />
<meta property="og:type"        content="article" />
<meta property="og:title"       content="{{ $listing->getRelation('deal')->getAttribute('name') }}" />
<meta property="og:description" content="{{ $listing->getRelation('deal')->getAttribute('description') }}" />
<meta property="og:image"       content="{{ url()->to('/').$listing->getRelation('deal')->getImage('760x500') }}" />

