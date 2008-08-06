$:.unshift(File.dirname(__FILE__) + "/../lib")
$:.push(File.dirname(__FILE__) + "/../fixtures")

require "function_defn"
require "reference_type"

require "ui"

module Environment
  extend self
  
  def cache_dir
    @cache_dir ||= File.join(File.expand_path(ENV['HOME'] || '~'), ".sv-ide")
  end
end