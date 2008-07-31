require "ostruct"
require "yaml"
class FunctionDefn < OpenStruct
  def self.find(name, interface = "1")
    unless test_env?
    else
      find_by_fixtures(name, interface)
    end
  end
  
  # Returns a list of function names that start with +partial+
  # Note, there may be 1+ interface versions for each result
  def self.find_by_partial(partial)
    unless test_env?
    else
      find_by_partial_by_fixtures(partial)
    end
  end
  
  # If no parameters provided to initializer, then return empty array.
  # Parameters should be an array of strings
  # If signature of function is: ReferenceCodeByLabel&(const c_Code$, const c_Reference$)
  # Then parameters will be: ['c_Code$', 'c_Reference$']
  def parameters
    super || []
  end
  
  protected
  def self.function_defns
    @@function_defns ||= begin
      function_defns = YAML.load(File.read(File.dirname(__FILE__) + "/../fixtures/function_defns.yml"))
      function_defns.inject({}) do |mem, func_def|
        name_interface, func = func_def
        name, interface = name_interface.split('-')
        mem[func["name"]] = { interface => self.new(func) }
        mem
      end
    end
  end

  def self.find_by_fixtures(name, interface = "1")
    function_defns[name][interface]
  end
  
  def self.find_by_partial_by_fixtures(partial)
    function_defns.keys.select { |func_name| func_name =~ /^#{partial}/ }
  end
  
  def self.test_env?
    ENV['EPM_ENV'] == 'test'
  end
end