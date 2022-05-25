<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($questions as $question)
    <url>
        <loc>{{ URL::route("view_question_route", [$question->slug, $question->id]) }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime($question->updated_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
@endforeach
</urlset>