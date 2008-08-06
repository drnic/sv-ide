require "test/unit"

$:.unshift(File.dirname(__FILE__) + "/../lib")
$:.unshift(File.dirname(__FILE__) + "/../bin")
$:.unshift(File.dirname(__FILE__) + "/../fixtures")

require "pp"
require "rubygems"
gem "Shoulda"
require "Shoulda"
gem "mocha"
require "mocha"

require "environment"
module Environment
  def self.cache_dir
    File.dirname(__FILE__) + "/../fixtures"
  end
end

class Test::Unit::TestCase
  def fixtures_dir
    File.dirname(__FILE__) + "/../fixtures"
  end
end

Context = Thoughtbot::Shoulda::Context