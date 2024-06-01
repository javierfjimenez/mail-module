@extends('layouts/contentLayoutMaster')

@section('title', 'Quill Editor')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Roboto+Slab&family=Slabo+27px&family=Sofia&family=Ubuntu+Mono&display=swap" rel="stylesheet">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
@endsection

@section('content')
<!-- Snow Editor start -->
<!-- <section class="snow-editor">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Snow Editor</h4>
        </div>
        <div class="card-body">
          <p class="card-text">Snow is a clean, flat toolbar theme.</p>
          <div class="row">
            <div class="col-sm-12">
              <div id="snow-wrapper">
                <div id="snow-container">
                  <div class="quill-toolbar">
                    <span class="ql-formats">
                      <select class="ql-header">
                        <option value="1">Heading</option>
                        <option value="2">Subheading</option>
                        <option selected>Normal</option>
                      </select>
                      <select class="ql-font">
                        <option selected>Sailec Light</option>
                        <option value="sofia">Sofia Pro</option>
                        <option value="slabo">Slabo 27px</option>
                        <option value="roboto">Roboto Slab</option>
                        <option value="inconsolata">Inconsolata</option>
                        <option value="ubuntu">Ubuntu Mono</option>
                      </select>
                    </span>
                    <span class="ql-formats">
                      <button class="ql-bold"></button>
                      <button class="ql-italic"></button>
                      <button class="ql-underline"></button>
                    </span>
                    <span class="ql-formats">
                      <button class="ql-list" value="ordered"></button>
                      <button class="ql-list" value="bullet"></button>
                    </span>
                    <span class="ql-formats">
                      <button class="ql-link"></button>
                      <button class="ql-image"></button>
                      <button class="ql-video"></button>
                    </span>
                    <span class="ql-formats">
                      <button class="ql-formula"></button>
                      <button class="ql-code-block"></button>
                    </span>
                    <span class="ql-formats">
                      <button class="ql-clean"></button>
                    </span>
                  </div>
                  <div class="editor">
                    <h1 class="ql-align-center">Quill Rich Text Editor</h1>
                    <p class="card-text"><br /></p>
                    <p class="card-text">
                      Quill is a free, <a href="https://github.com/quilljs/quill/">open source</a> WYSIWYG editor built
                      for the modern web. With its
                      <a href="http://quilljs.com/docs/modules/">modular architecture</a> and expressive
                      <a href="http://quilljs.com/docs/api/">API</a>, it is completely customizable to fit any need.
                    </p>
                    <p class="card-text"><br /></p>
                    <iframe
                      class="ql-video ql-align-center"
                      src="https://www.youtube.com/embed/QHH3iSeDBLo?showinfo=0"
                      width="560"
                      height="238"
                    ></iframe>
                    <p class="card-text"><br /></p>
                    <p class="card-text"><br /></p>
                    <h2 class="ql-align-center">Getting Started is Easy</h2>
                    <p class="card-text"><br /></p>
                    <pre>
// &lt;link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"&gt;
// &lt;script src="https://cdn.quilljs.com/1.3.6/quill.min.js" type="text/javascript"&gt;&lt;/script&gt;
var quill = new Quill('#editor', {
    modules: {
        toolbar: '#toolbar'
    },
    theme: 'snow'
});
// Open your browser's developer console to try out the API!</pre
                    >
                    <p class="card-text"><br /></p>
                    <p class="card-text"><br /></p>
                    <p class="card-text ql-align-center"><strong>Built with</strong></p>
                    <p class="card-text ql-align-center">
                      &nbsp;<span class="ql-formula" data-value="x^2 + (y - \sqrt[3]{x^2})^2 = 1"></span>&nbsp;
                    </p>
                    <p class="card-text"><br /></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> -->
<!-- Snow Editor end -->

<!-- Bubble Editor start -->
<!-- <section class="quill-editor">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Bubble Editor</h4>
        </div>
        <div class="card-body">
          <p class="card-text">
            <code>Bubble</code> is a simple tooltip based theme. Try double clicking on text, you should see bubble with
            toolbars for editing.
          </p>
          <div class="row">
            <div class="col-sm-12">
              <div id="bubble-wrapper">
                <div id="bubble-container">
                  <div class="editor">
                    <h1 class="ql-align-center">Quill Rich Text Editor</h1>
                    <p class="card-text"><br /></p>
                    <p class="card-text">
                      Quill is a free, <a href="https://github.com/quilljs/quill/">open source</a> WYSIWYG editor built
                      for the modern web. With its
                      <a href="http://quilljs.com/docs/modules/">modular architecture</a> and expressive
                      <a href="http://quilljs.com/docs/api/">API</a>, it is completely customizable to fit any need.
                    </p>
                    <p class="card-text"><br /></p>
                    <iframe
                      class="ql-video ql-align-center"
                      src="https://www.youtube.com/embed/QHH3iSeDBLo?showinfo=0"
                      width="560"
                      height="238"
                    ></iframe>
                    <p class="card-text"><br /></p>
                    <p class="card-text"><br /></p>
                    <h2 class="ql-align-center">Getting Started is Easy</h2>
                    <p class="card-text"><br /></p>
                    <pre class="language-javascript">
<code class="language-javascript">
// &lt;link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"&gt;
// &lt;script src="https://cdn.quilljs.com/1.3.6/quill.min.js" type="text/javascript"&gt;&lt;/script&gt;
var quill = new Quill('#editor', {
    modules: {
        toolbar: '#toolbar'
    },
    theme: 'bubble'
});
// Open your browser's developer console to try out the API!
</code>
                      </pre>
                    <p class="card-text"><br /></p>
                    <p class="card-text"><br /></p>
                    <p class="card-text ql-align-center"><strong>Built with</strong></p>
                    <p class="card-text ql-align-center">
                      &nbsp;<span class="ql-formula" data-value="x^2 + (y - \sqrt[3]{x^2})^2 = 1"></span>&nbsp;
                    </p>
                    <p class="card-text"><br /></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> -->
<!-- Bubble Editor end -->

<!-- full Editor start -->
<section class="full-editor">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Plantilla de correos</h4>
        </div>
        <div class="card-body">
          <!-- <p class="card-text">
            By default all formats are enabled and allowed to exist within a Quill editor and can be configured with the
            <code>formats</code> option. This is separate from adding a control in the <code>Toolbar</code>. For
            example, you can configure Quill to allow bolded content to be pasted into an editor that has no bold button
            in the toolbar.
          </p> -->
          <div class="row">
            <div class="col-sm-12">
              <div id="full-wrapper">
                <div id="full-container">
                  <div class="editor">
                  <p>&nbsp;</p>


<div style="-webkit-text-stroke-width:0px; margin-left:auto; margin-right:auto">
<table id="m_-4047652640647140030Table_01" style="border:undefined">
    <tbody>
        <tr>
            <td>
            <table align="center" id="m_-4047652640647140030backgroundTable" style="border:undefined; width:100%">
                <tbody>
                    <tr>
                        <td style="vertical-align:top">
                        <table align="center" id="m_-4047652640647140030newsTable" style="border:undefined; width:600px">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top">
                                    <div id="m_-4047652640647140030container" style="padding:0px">
                                    <table align="center" style="border:undefined; width:100%">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align:top">
                                                <table style="border:undefined; width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:center; vertical-align:top">&nbsp;
                                                            <p><sub><img src="{{asset('images/email-template/Logo.png')}}"  style="height:154px; width:235px" /></sub></p>


                                                            <p><sup><span style="font-family:Verdana,Geneva,sans-serif"><span style="font-size:11px"><strong>__</strong></span></span></sup></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                &nbsp;


                                                <table style="border:undefined; width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:center; vertical-align:top">&nbsp;
                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:center"><span style="font-family:Verdana,Geneva,sans-serif"><span style="font-size:11px"><strong>__</strong></span></span></p>


                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:center"><span style="font-size:10px"><strong><span style="font-family:Arial,Helvetica,sans-serif"><span style="background-color:white"><span style="color:#555555">**DISCLAIMER**</span></span></span></strong></span></p>


                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:justify"><span style="font-size:10px"><span style="font-family:Arial,Helvetica,sans-serif"><span style="background-color:white"><span style="color:#555555">We inform you, as the recipient of this message, that electronic mail and communications via the Internet do not allow the confidentiality of the messages transmitted, nor their integrity or correct reception, to be assured or guaranteed, for which BANCO CENTRAL DE VENEZUELA (BCV) assumes no responsibility for such circumstances. If you do not consent to the use of email or communications via the Internet, please notify us and let us know immediately. This message is addressed exclusively to its recipient and contains confidential information subject to professional secrecy, the disclosure of which is not permitted by law. If you have received this message by mistake, please immediately remove it, as well as any document attached to it. Likewise, we inform you that the distribution, copying or use of this message, or any document attached to it, whatever its purpose, is prohibited by law.</span></span></span></span></p>


                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:justify"><span style="font-size:10px"><span style="font-family:Arial,Helvetica,sans-serif"><span style="background-color:white"><span style="color:#555555">For the purposes of the provisions of current regulations regarding the protection of personal data, we inform you that your data will be incorporated into an automated personal data file, created under the responsibility of BANCO CENTRAL DE VENEZUELA (BCV) with the in order to offer you a more personalized, agile and efficient service.</span></span></span></span></p>


                                                            <p style="margin-left:0cm; margin-right:0cm; text-align:justify"><span style="font-size:10px"><span style="font-family:Arial,Helvetica,sans-serif"><span style="background-color:white"><span style="color:#555555">BANCO CENTRAL DE VENEZUELA (BCV) undertakes to comply with its obligation to secrecy of personal data and its duty to store it, and will adopt the necessary measures to prevent its alteration, loss, treatment or unauthorized access, taking into account all times of the state of technology.</span></span></span></span></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                                <table style="border:undefined; width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:center; vertical-align:top"><a href="#"><img src="{{asset('images/email-template/TerminosCondiciones.png')}}" style="height:19px; width:735px" /></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                &nbsp;


                                                <table style="border:undefined; width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:center; vertical-align:top"><a href="http://www.bcv.org.ve" target="_blank"><img s alt="Banco Central de Venezuela (BCV)" src="{{asset('images/email-template/Web.png')}}" style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="https://www.facebook.com/Banco-Central-de-Venezuela-937741406327397/" target="_blank"><img alt="Facebook BCV" src="{{asset('images/email-template/Facebook.png')}}" style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="http://www.bcv.org.ve/bcv/contactos" target="_blank"><img alt="Contactos BCV" src="{{asset('images/email-template/Contactos.png')}}" style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="https://twitter.com/BCV_ORG_VE" target="_blank"><img alt="Twitter BVC" src="{{asset('images/email-template/Twitter.png')}}" style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="https://www.instagram.com/bcv.org.ve/" target="_blank"><img alt="Instagram BCV" src="{{asset('images/email-template/Instagram.png')}}"style="height:30px; width:30px" /></a></td>
                                                            <td style="text-align:center; vertical-align:top"><a href="https://www.youtube.com/user/BancoCentralBCV" target="_blank"><img alt="Youtube BCV" src="{{asset('images/email-template/Youtube.png')}}" style="height:30px; width:30px" /></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                    </td>
                                    <td style="vertical-align:top">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>
</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- full Editor end -->
@endsection

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/form-quill-editor.js')) }}"></script>
@endsection