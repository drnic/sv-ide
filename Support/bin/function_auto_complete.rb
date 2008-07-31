#!/usr/bin/env ruby
#
# Function Autocomplete Command

require File.dirname(__FILE__) + '/../lib/function_defn'
require "ui"

class FunctionAutoComplete
  def self.run(partial_word)
    if function_list = FunctionDefn.find_by_partial(partial_word)
      function_name = TextMate::UI.request_item(:title => "Select function", :items => function_list.map { |func_name| func_name })
      function_name || partial_word
    else
      partial_word
    end
  end
end

if $0 == __FILE__
  print FunctionAutoComplete.run(ENV['TM_CURRENT_WORD'])
end