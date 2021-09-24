<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@if(isset($type) && $type== 'blog_post')
	<url>
		<loc>https://debutify.com/blog/</loc>
	</url>
	@foreach($blogs as $blog)
	<url>
		<loc>{{ route('blog_slug', $blog->slug) }}/</loc>
		<lastmod>{{ date(DATE_ISO8601, strtotime($blog->created_at)) }}</lastmod>
		<image:image>
			<image:loc>{{ $blog->featured_image }}</image:loc>
			<image:title><![CDATA[{{ $blog->title }}]]></image:title>
			<image:caption><![CDATA[{{ $blog->title }}]]></image:caption>
		</image:image>
	</url>
	@endforeach
	@endif
	@if(isset($page_title))
	@foreach($blogs as $meta)
	<url>
		@if($page_title == 'tags'){
		<loc>{{Route('blog_tag_slug', $meta->slug)}}/</loc>
		@else
		<loc>{{Route('blog_category_slug', $meta->slug)}}/</loc>
		@endif
	</url>
	@endforeach
	@endif
</urlset>
<!-- XML Sitemap generated by Debutify-->