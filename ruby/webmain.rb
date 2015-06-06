require 'sinatra'
require 'sinatra/reloader' if development?
require 'slim'
require 'sass'
require 'sequel'

class RoadworksApp < Sinatra::Application

  get('/css/style.css') { scss :style }

  get '/' do
    slim :index
  end
end

__END__

@@style

body {
  background: white;
  color: #111;
  font-family: "Lucida Sans", "Lucida Grande", Lucida, sans-serif;
  font-size: 12pt;
  line-height: 15pt;
}

.container { width: 960px; margin: 0 auto }

/*** Header and Footer */

header      { height: 120px; background: #f8f8f8 url('/header-bg.png') repeat-x; }
header img  { float: left; margin: 10px; }
header h1   { letter-spacing: 0.08em; padding-top: 40px; font-size: 280%; }

footer {
    background-color: #eee;
    overflow: hidden;
    height: 80px;
    line-height: 40px;
    padding: 0;
}

footer img      { margin: 10px 2em 0 10px; float: left; }

footer nav      { display: block; font-size: 80%; }
footer nav li   { display: inline; float: left; width: 6em; }

footer small {
    text-align: center;
    font-size: 65%;
    clear: both;
    display: block;
}
