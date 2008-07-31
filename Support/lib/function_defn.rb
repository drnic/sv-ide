require "ostruct"
class FunctionDefn < OpenStruct
  def self.find(name)
    unless test_env?
    else
      find_by_fixtures(name)
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
  def self.find_by_fixtures(name, interface = "1")
    @@function_defns ||= begin
      function_defns = YAML.load(File.read(File.dirname(__FILE__) + "/../fixtures/function_defns.yml"))
      function_defns.inject({}) do |mem, func_def|
        name_interface, func = func_def
        name, interface = name_interface.split('-')
        mem[name] = { interface => self.new(func) }
        mem
      end
    end
    @@function_defns[name][interface]
  end
  
  def self.test_env?
    ENV['EPM_ENV'] == 'test'
  end
end