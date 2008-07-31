#!/usr/bin/env ruby
#
# Function Autocomplete Command

require File.dirname(__FILE__) + '/../lib/function_defn'
require "ui"

class FunctionAutoComplete
  def self.run(partial_word)
    return partial_word unless function_list = FunctionDefn.find_by_partial(partial_word)
    return partial_word unless function_name = TextMate::UI.request_item(:title => "Select function", :items => function_list.map { |func_name| func_name })
    function = FunctionDefn.find(function_name)
    tab_count = 0
    arguments = function.parameters.map do |param|
      tab_count += 1
      param = param.gsub('$', '\$') # snippets treat $ special so escape them
      "${#{tab_count}:#{param}}"
    end.join(", ")
    "#{function_name}(#{arguments})"
  end
end

if $0 == __FILE__
  print FunctionAutoComplete.run(ENV['TM_CURRENT_WORD'])
end