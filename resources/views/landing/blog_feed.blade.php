<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:wfw="http://wellformedweb.org/CommentAPI/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
  xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
  >
<channel>
  <title>Debutify</title>
  <atom:link href="https://debutify.com/blog/feed/" rel="self" type="application/rss+xml" />
  <link>https://debutify.com/blog</link>
  <description>BLOG</description>
  <lastBuildDate>Fri, 30 Oct 2020 04:36:57 +0000</lastBuildDate>
  <language>en-US</language>
  <sy:updatePeriod> hourly  </sy:updatePeriod>
  <sy:updateFrequency> 1 </sy:updateFrequency>
  <generator>https://debutify.com/blog</generator>
  <image>
    <url>https://debutify.com/blog/wp-content/uploads/2019/11/cropped-37879448_414741532349291_1176000794839744512_o-1-32x32.png</url>
    <title>Debutify</title>
    <link>https://debutify.com/blog</link>
    <width>32</width>
    <height>32</height>
  </image> 

    @foreach($blogs as $blog)
    @php

      $description = html_entity_decode(htmlspecialchars_decode(strip_tags($blog->description), ENT_QUOTES));
            if (strlen($description) > 250 && preg_match('/\s/', $description)) {
            $pos = strpos($description, ' ', 250);
            $og_description = substr($description, 0, $pos);
          } else {
          $og_description = $latest_blog_same_category->description;
        }
        @endphp

    <item>
      <title>{{ $blog->title }}></title>
      <link>{{ route('blog_slug', $blog->slug) }}</link>
      <comments>{{ route('blog_slug', $blog->slug) }}/#respond</comments>
      <pubDate>{{ $blog->created_at->format(DateTime::RSS) }}</pubDate>
      <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/">{{ $blog->currentauthUser['name'] }}</dc:creator>
      @foreach($blog->categories as $k => $meta)
           <category><![CDATA[{{htmlspecialchars_decode($meta->meta_name)}}]]></category>
      @endforeach
      <guid isPermaLink="true">{{ route('blog_slug', $blog->slug) }}</guid>
      <description><![CDATA[{{ $og_description }}]]></description>
      <content:encoded><![CDATA[{!! $blog->description !!}]]></content:encoded>
      <wfw:commentRss>{{ route('blog_slug', $blog->slug) }}/feed/</wfw:commentRss>
      <slash:comments>0</slash:comments>

    </item>
    @endforeach
  </channel>
</rss>