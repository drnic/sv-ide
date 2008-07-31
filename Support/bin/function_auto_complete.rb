#!/usr/bin/env ruby
#
# Function Autocomplete Command

require File.dirname(__FILE__) + '/../lib/function_defn'
require "ui"

class FunctionAutoComplete
  def self.run(partial_word)
    return partial_word unless function_list = FunctionDefn.find_by_partial(partial_word)
    return partial_word unless function_name = TextMate::UI.request_item(:title => "Select function", :items => function_list.map { |func_name| func_name })

    function_interfaces_hash = FunctionDefn.find_by_name(function_name)
    function_interfaces = function_interfaces_hash.values.sort { |a, b| a.interface <=> b.interface }
    function = function_interfaces.first
    if function_interfaces.length > 1
      signatures = function_interfaces.map { |f| f.signature }
      signature = TextMate::UI.request_item(:title => "Select interface", :items => signatures)
      return partial_word unless signature
      function = function_interfaces.find { |interface| interface.signature == signature }
    end

    # generate the snippet
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