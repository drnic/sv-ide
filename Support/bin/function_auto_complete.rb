#!/usr/bin/env ruby
#
# Function Autocomplete Command

require File.dirname(__FILE__) + '/../lib/function_defn'
require "ui"

class FunctionAutoComplete
  def self.run(partial_word)
    return partial_word unless function_list = FunctionDefn.find_by_partial(partial_word)
    function_name = function_list.first
    if function_list.length > 1
      functions = function_list.map { |func_name| {"title" => func_name} }
      return partial_word unless function_name = TextMate::UI.menu(functions)
      function_name = function_name["title"]
    end
    function_interfaces_hash = FunctionDefn.find_by_name(function_name)
    function_interfaces = function_interfaces_hash.values.sort { |a, b| a.interface <=> b.interface }
    function = function_interfaces.first
    if function_interfaces.length > 1
      signatures = function_interfaces.map { |f| {"title" => f.signature} }
      return partial_word unless signature = TextMate::UI.menu(signatures)
      function = function_interfaces.find { |interface| interface.signature == signature["title"] }
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