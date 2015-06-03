# Read XML

require 'nokogiri'
require 'pp'

doc = Nokogiri::XML(File.open("ha_roadworks_2015_06_01.xml"))
works = doc.xpath('//ha_planned_works')
first = works.first.children

puts "Nodes: #{works.count}, first nodes: #{first.count}"

fields = first.reduce({}) do |acc, node|
  acc[node.name] = node.children.text if node.name != 'text'
  acc
end

pp fields
