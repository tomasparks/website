<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeTest extends PHPUnit_Framework_TestCase {

  private $http;

  public function setUp() {
    $this->client = new Parse();
    $this->client->http = new p3k\HTTP\Test(dirname(__FILE__).'/data/');
    $this->client->mc = null;
  }

  private function parse($params) {
    $request = new Request($params);
    $response = new Response();
    return $this->client->parse($request, $response);
  }

  public function testAllowsWhitelistedTags() {
    $url = 'http://sanitize.example/entry-with-valid-tags';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);
    $html = $data['data']['content']['html'];

    $this->assertEquals('entry', $data['data']['type']);
    $this->assertContains('This content has only valid tags.', $html); 
    $this->assertContains('<a href="http://sanitize.example/example">links</a>,', $html, '<a> missing'); 
    $this->assertContains('<abbr>abbreviations</abbr>,', $html, '<abbr> missing'); 
    $this->assertContains('<b>bold</b>,', $html, '<b> missing'); 
    $this->assertContains('<code>inline code</code>,', $html, '<code> missing'); 
    $this->assertContains('<del>delete</del>,', $html, '<del> missing'); 
    $this->assertContains('<em>emphasis</em>,', $html, '<em> missing'); 
    $this->assertContains('<i>italics</i>,', $html, '<i> missing'); 
    $this->assertContains('<img src="http://sanitize.example/example.jpg" alt="images are allowed" />', $html, '<img> missing'); 
    $this->assertContains('<q>inline quote</q>,', $html, '<q> missing');
    $this->assertContains('<strike>strikethrough</strike>,', $html, '<strike> missing');
    $this->assertContains('<strong>strong text</strong>,', $html, '<strong> missing');
    $this->assertContains('<time datetime="2016-01-01">time elements</time>', $html, '<time> missing');
    $this->assertContains('<blockquote>Blockquote tags are okay</blockquote>', $html);
    $this->assertContains('<pre>preformatted text is okay too', $html, '<pre> missing');
    $this->assertContains('for code examples and such</pre>', $html, '<pre> missing');
    $this->assertContains('<p>Paragraph tags are allowed</p>', $html, '<p> missing');
    $this->assertContains('<h1>One</h1>', $html, '<h1> missing');
    $this->assertContains('<h2>Two</h2>', $html, '<h2> missing');
    $this->assertContains('<h3>Three</h3>', $html, '<h3> missing');
    $this->assertContains('<h4>Four</h4>', $html, '<h4> missing');
    $this->assertContains('<h5>Five</h5>', $html, '<h5> missing');
    $this->assertContains('<h6>Six</h6>', $html, '<h6> missing');
    $this->assertContains('<ul>', $html, '<ul> missing');
    $this->assertContains('<li>One</li>', $html, '<li> missing');
  }

  public function testRemovesUnsafeTags() {
    $url = 'http://sanitize.example/entry-with-unsafe-tags';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);
    $html = $data['data']['content']['html'];
    $text = $data['data']['content']['text'];

    $this->assertEquals('entry', $data['data']['type']);
    $this->assertNotContains('<script>', $html);
    $this->assertNotContains('<style>', $html);
    $this->assertNotContains('visiblity', $html); // from the CSS
    $this->assertNotContains('alert', $html); // from the JS
    $this->assertNotContains('visiblity', $text);
    $this->assertNotContains('alert', $text);
  }

  public function testAllowsMF2Classes() {
    $url = 'http://sanitize.example/entry-with-mf2-classes';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);
    $html = $data['data']['content']['html'];

    $this->assertEquals('entry', $data['data']['type']);
    $this->assertContains('<h2 class="p-name">Hello World</h2>', $html);
    $this->assertContains('<h3>Utility Class</h3>', $html);
  }

  public function testEscapingHTMLTagsInText() {
    $url = 'http://sanitize.example/html-escaping-in-text';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals('entry', $data['data']['type']);
    $this->assertEquals('This content has some HTML escaped entities such as & ampersand, " quote, escaped <code> HTML tags, an ümlaut, an @at sign.', $data['data']['content']['text']);
  }

  public function testEscapingHTMLTagsInHTML() {
    $url = 'http://sanitize.example/html-escaping-in-html';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals('entry', $data['data']['type']);
    $this->assertArrayNotHasKey('name', $data['data']);
    $this->assertEquals('This content has some HTML escaped entities such as & ampersand, " quote, escaped <code> HTML tags, an ümlaut, an @at sign.', $data['data']['content']['text']);
    $this->assertEquals('This content has some <i>HTML escaped</i> entities such as &amp; ampersand, " quote, escaped &lt;code&gt; HTML tags, an ümlaut, an @at sign.', $data['data']['content']['html']);
  }

  public function testSanitizeJavascriptURLs() {
    $url = 'http://sanitize.example/h-entry-with-javascript-urls';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body, true);

    $this->assertEquals('entry', $data['data']['type']);
    $this->assertEquals('', $data['data']['author']['url']);
    $this->assertArrayNotHasKey('url', $data['data']);
    $this->assertArrayNotHasKey('photo', $data['data']);
    $this->assertArrayNotHasKey('audio', $data['data']);
    $this->assertArrayNotHasKey('video', $data['data']);
    $this->assertArrayNotHasKey('syndication', $data['data']);
    $this->assertArrayNotHasKey('in-reply-to', $data['data']);
    $this->assertArrayNotHasKey('like-of', $data['data']);
    $this->assertArrayNotHasKey('repost-of', $data['data']);
    $this->assertArrayNotHasKey('bookmark-of', $data['data']);
    $this->assertEquals('Author', $data['data']['author']['name']);
    $this->assertEquals('', $data['data']['author']['photo']);
  }

  public function testSanitizeEmailAuthorURL() {
    $url = 'http://sanitize.example/h-entry-with-email-author';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertEquals('entry', $data->data->type);
    $this->assertEquals('', $data->data->author->url);
    $this->assertEquals('Author', $data->data->author->name);
    $this->assertEquals('http://sanitize.example/photo.jpg', $data->data->author->photo);
  }

  public function testPhotoInContentNoAlt() {
    // https://github.com/aaronpk/XRay/issues/52

    $url = 'http://sanitize.example/photo-in-content';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertObjectNotHasAttribute('name', $data->data);
    $this->assertEquals('http://target.example.com/photo.jpg', $data->data->photo[0]);
    $this->assertEquals('This is a photo post with an img tag inside the content.', $data->data->content->text);
    $this->assertEquals('This is a photo post with an <code>img</code> tag inside the content.', $data->data->content->html);
  }

  /*
  // Commented out until #56 is resolved
  // https://github.com/aaronpk/XRay/issues/56
  public function testPhotoInTextContentNoAlt() {
    $url = 'http://sanitize.example/photo-in-text-content';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertObjectNotHasAttribute('name', $data->data);
    $this->assertEquals('http://target.example.com/photo.jpg', $data->data->photo[0]);
    $this->assertEquals('This is a photo post with an img tag inside the content.', $data->data->content->text);
    $this->assertEquals('This is a photo post with an <code>img</code> tag inside the content.', $data->data->content->html);
  }
  */

  public function testPhotoInContentEmptyAltAttribute() {
    // https://github.com/aaronpk/XRay/issues/52
    
    $url = 'http://sanitize.example/photo-in-content-empty-alt';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertObjectNotHasAttribute('name', $data->data);
    $this->assertEquals('http://target.example.com/photo.jpg', $data->data->photo[0]);
    $this->assertEquals('This is a photo post with an img tag inside the content.', $data->data->content->text);
    $this->assertEquals('This is a photo post with an <code>img</code> tag inside the content.', $data->data->content->html);
  }

  public function testPhotoInContentWithAlt() {
    // https://github.com/aaronpk/XRay/issues/52
    
    $url = 'http://sanitize.example/photo-in-content-with-alt';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertObjectNotHasAttribute('name', $data->data);
    $this->assertEquals('http://target.example.com/photo.jpg', $data->data->photo[0]);
    $this->assertEquals('This is a photo post with an img tag inside the content.', $data->data->content->text);
    $this->assertEquals('This is a photo post with an <code>img</code> tag inside the content.', $data->data->content->html);    
  }

  public function testPhotoInContentWithNoText() {
    $url = 'http://sanitize.example/cleverdevil';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertObjectHasAttribute('name', $data->data);
    $this->assertEquals('Oh, how well they know me! 🥃', $data->data->name);
    $this->assertObjectNotHasAttribute('content', $data->data);
    $this->assertEquals('https://cleverdevil.io/file/5bf2fa91c3d4c592f9978200923cb56e/thumb.jpg', $data->data->photo[0]);
  }

  public function testPhotoWithDupeNameAndAlt1() {
    // https://github.com/aaronpk/XRay/issues/57
    $url = 'http://sanitize.example/photo-with-dupe-name-alt';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertObjectHasAttribute('name', $data->data);
    $this->assertEquals('Photo caption', $data->data->name);
    $this->assertObjectNotHasAttribute('content', $data->data);
    $this->assertEquals('http://sanitize.example/photo.jpg', $data->data->photo[0]);
  }

  public function testPhotoWithDupeNameAndAlt2() {
    // This is simliar to adactio's markup
    // https://adactio.com/notes/13301
    $url = 'http://sanitize.example/photo-with-dupe-name-alt-2';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertObjectHasAttribute('content', $data->data);
    $this->assertEquals('Photo caption', $data->data->content->text);
    $this->assertObjectNotHasAttribute('name', $data->data);
    $this->assertEquals('http://sanitize.example/photo.jpg', $data->data->photo[0]);
  }

  public function testPhotosWithAlt() {
    // https://github.com/microformats/microformats2-parsing/issues/16

    $url = 'http://sanitize.example/photos-with-alt';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    #print_r($data->data);

    $this->assertEquals('🌆 Made it to the first #NPSF #earlygang of the year, did in-betweeners abs, and 6:30 workout with a brutal burnout that was really its own workout. But wow pretty sunrise. Plus 50+ deg F? I’ll take it. #100PDPD#justshowup #darknesstodawn #wakeupthesun #fromwhereirun #NovemberProject #sunrise #latergram #nofilter', $data->data->content->text);
    $this->assertObjectNotHasAttribute('name', $data->data);
    $this->assertEquals('https://igx.4sqi.net/img/general/original/476_g7yruXflacsGr7PyVmECefyTBMB_R99zmPQxW7pftzA.jpg', $data->data->photo[0]);
    $this->assertEquals('https://igx.4sqi.net/img/general/original/476_zM3UgU9JHNhom907Ac_1WCEcUhGOJZaNWGlRmev86YA.jpg', $data->data->photo[1]);
  }

  /*
  // Commented out until #55 is resolved
  // https://github.com/aaronpk/XRay/issues/55
  public function testEntryWithImgNoImpliedPhoto() {
    // See https://github.com/microformats/microformats2-parsing/issues/6#issuecomment-357286985
    // and https://github.com/aaronpk/XRay/issues/52#issuecomment-357269683
    // and https://github.com/microformats/microformats2-parsing/issues/16
    $url = 'http://sanitize.example/entry-with-img-no-implied-photo';
    $response = $this->parse(['url' => $url]);

    $body = $response->getContent();
    $this->assertEquals(200, $response->getStatusCode());
    $data = json_decode($body);

    $this->assertObjectNotHasAttribute('photo', $data->data);
    $this->assertObjectNotHasAttribute('name', $data->data);
    $this->assertEquals('http://target.example.com/photo.jpg', $data->data->photo[0]);
    $this->assertEquals('This is a photo post with an img tag inside the content, which does not have a u-photo class so should not be removed.', $data->data->content->text);
    $this->assertEquals('This is a photo post with an <code>img</code> tag inside the content, which does not have a u-photo class so should not be removed. <img src="http://target.example.com/photo.jpg" alt="a photo">', $data->data->content->html);
  }
  */

}
