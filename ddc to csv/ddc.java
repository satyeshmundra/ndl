import org.w3c.dom.*;
import javax.xml.parsers.*;
import java.io.*;
import java.util.ArrayList;
import javax.xml.xpath.*;

class ddc
{
	File fxmlFile = new File("ddcE.xml");

	ArrayList<String> getAllDDCSubjects(String exactDDCSubjectCode)
	{

		ArrayList<String> DDCSubjects = new ArrayList<String>();
		String first_two = exactDDCSubjectCode.substring(0,2) + '0';
		String first = exactDDCSubjectCode.substring(0,1) + "00_";
		String s, s1;
		try
		{	
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();

			Document doc = builder.parse(fxmlFile);
			XPathFactory xpathFactory = XPathFactory.newInstance();
        	XPath xpath = xpathFactory.newXPath();
	        try
	        {	
				Element eElement = (Element) xpath.evaluate("//*[@id='"+exactDDCSubjectCode+"']", doc, XPathConstants.NODE);
				s = eElement.getAttribute("label");
				s1 = s.substring(0, 3) + "::" + s.substring(4);
				DDCSubjects.add(s1);
			}
			catch(Exception e)
			{

			}
			try
			{
				Element eElement = (Element) xpath.evaluate("//*[@id='"+first_two+"']", doc, XPathConstants.NODE);
				s = eElement.getAttribute("label");
				s1 = s.substring(0, 3) + "::" + s.substring(4);
				DDCSubjects.add(s1);
			}
			catch(Exception e)
			{

			}
			try
			{
				Element eElement = (Element) xpath.evaluate("//*[@id='"+first+"']", doc, XPathConstants.NODE);
				s = eElement.getAttribute("label");
				s1 = s.substring(0, 3) + "::" + s.substring(4);
				DDCSubjects.add(s1);
			}
			catch(Exception e)
			{

			}
		}
		catch(Exception e)
		{
			e.printStackTrace();
		}
		return DDCSubjects;
	}

	public static void main(String args[])
	{
		ArrayList<String> subjects;
		ddc obj = new ddc();
		subjects = obj.getAllDDCSubjects("123");
		//to print the arraylist
			for (int i = 0; i < subjects.size() ; i++ ) {

				System.out.println(subjects.get(i));
				
			}
	}
}